ToolUserCode

<?php

	/**
     * Sends an email to a user with a link to verify their new account
     *
     * @param string $email    The user's email address
     * @param string $ver    The random verification code for the user
     * @return boolean        TRUE on successful send and FALSE on failure
     */
    private function sendVerificationEmail($email, $ver)
    {
        $e = sha1($email); // For verification purposes
        $to = trim($email);

        $subject = "[Colored Lists] Please Verify Your Account";

        $headers = <<<MESSAGE
From: Colored Lists <donotreply@coloredlists.com>
Content-Type: text/plain;
MESSAGE;

        $msg = <<<EMAIL
You have a new account at Colored Lists!

To get started, please activate your account and choose a
password by following the link below.

Your Username: $email

Activate your account: http://coloredlists.com/accountverify.php?v=$ver&e=$e

If you have any questions, please contact help@coloredlists.com.

--
Thanks!

EMAIL;

        return mail($to, $subject, $msg, $headers);
    }
	
	/**
     * Checks credentials and verifies a user account
     *
     * @return array    an array containing a status code and status message
     */
    public function verifyAccount()
    {
        $sql = "SELECT Username
                FROM users
                WHERE ver_code=:ver
                AND SHA1(Username)=:user
                AND verified=0";

        if($stmt = $this->_db->prepare($sql))
        {
            $stmt->bindParam(':ver', $_GET['v'], PDO::PARAM_STR);
            $stmt->bindParam(':user', $_GET['e'], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if(isset($row['user_name']))
            {
                // Logs the user in if verification is successful
                $_SESSION['Username'] = $row['user_name'];
                $_SESSION['LoggedIn'] = 1;
            }
            else
            {
                return array(4, "<h2>Verification Error</h2>n"
                    . "<p>This account has already been verified. "
                    . "Did you <a href="/'password.php'">forget "
                    . "your password?</a></p>");
            }
            $stmt->closeCursor();

            // No error message is required if verification is successful
            return array(0, NULL);
        }
        else
        {
            return array(2, "<h2>Error</h2>n<p>Database error.</p>");
        }
    }
	
	/**
     * Changes the user's password
     *
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function updatePassword()
    {
        if(isset($_POST['p'])
        && isset($_POST['r'])
        && $_POST['p']==$_POST['r'])
        {
            $sql = "UPDATE users
                    SET Password=MD5(:pass), verified=1
                    WHERE ver_code=:ver
                    LIMIT 1";
            try
            {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":pass", $_POST['p'], PDO::PARAM_STR);
                $stmt->bindParam(":ver", $_POST['v'], PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();

                return TRUE;
            }
            catch(PDOException $e)
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
	
	/**
     * Checks credentials and logs in the user
     *
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function accountLogin()
    {
        $sql = "SELECT Username
                FROM users
                WHERE Username=:user
                AND Password=MD5(:pass)
                LIMIT 1";
        try
        {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':user', $_POST['username'], PDO::PARAM_STR);
            $stmt->bindParam(':pass', $_POST['password'], PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount()==1)
            {
                $_SESSION['Username'] = htmlentities($_POST['username'], ENT_QUOTES);
                $_SESSION['LoggedIn'] = 1;
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        catch(PDOException $e)
        {
            return FALSE;
        }
    }
	
	/**
     * Retrieves the ID and verification code for a user
     *
     * @return mixed    an array of info or FALSE on failure
     */
    public function retrieveAccountInfo()
    {
        $sql = "SELECT UserID, ver_code
                FROM users
                WHERE Username=:user";
        try
        {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':user', $_SESSION['Username'], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            $stmt->closeCursor();
            return array($row['UserID'], $row['ver_code']);
        }
        catch(PDOException $e)
        {
            return FALSE;
        }
    }
	
	/**
     * Changes a user's email address
     *
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function updateEmail()
    {
        $sql = "UPDATE users
                SET Username=:email
                WHERE UserID=:user
                LIMIT 1";
        try
        {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':email', $_POST['username'], PDO::PARAM_STR);
            $stmt->bindParam(':user', $_POST['userid'], PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();

            // Updates the session variable
            $_SESSION['Username'] = htmlentities($_POST['username'], ENT_QUOTES);

            return TRUE;
        }
        catch(PDOException $e)
        {
            return FALSE;
        }
    }
	
	/**
     * Changes the user's password
     *
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function updatePassword()
    {
        if(isset($_POST['p'])
        && isset($_POST['r'])
        && $_POST['p']==$_POST['r'])
        {
            $sql = "UPDATE users
                    SET Password=MD5(:pass), verified=1
                    WHERE ver_code=:ver
                    LIMIT 1";
            try
            {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":pass", $_POST['p'], PDO::PARAM_STR);
                $stmt->bindParam(":ver", $_POST['v'], PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();

                return TRUE;
            }
            catch(PDOException $e)
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
	
	/**
     * Deletes an account and all associated lists and items
     *
     * @return void
     */
    public function deleteAccount()
    {
        if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1)
        {
            // Delete list items
            $sql = "DELETE FROM list_items
                    WHERE ListID=(
                        SELECT ListID
                        FROM lists
                        WHERE UserID=:user
                        LIMIT 1
                    )";
            try
            {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":user", $_POST['user-id'], PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }

            // Delete the user's list(s)
            $sql = "DELETE FROM lists
                    WHERE UserID=:user";
            try
            {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":user", $_POST['user-id'], PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }

            // Delete the user
            $sql = "DELETE FROM users
                    WHERE UserID=:user
                    AND Username=:email";
            try
            {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":user", $_POST['user-id'], PDO::PARAM_INT);
                $stmt->bindParam(":email", $_SESSION['Username'], PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }

            // Destroy the user's session and send to a confirmation page
            unset($_SESSION['LoggedIn'], $_SESSION['Username']);
            header("Location: /gone.php");
            exit;
        }
        else
        {
            header("Location: /account.php?delete=failed");
            exit;
        }
    }
	
	/**
     * Resets a user's status to unverified and sends them an email
     *
     * @return mixed    TRUE on success and a message on failure
     */
    public function resetPassword()
    {
        $sql = "UPDATE users
                SET verified=0
                WHERE Username=:user
                LIMIT 1";
        try
        {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":user", $_POST['username'], PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }

        // Send the reset email
        if(!$this->sendResetEmail($_POST['username'], $v))
        {
            return "Sending the email failed!";
        }
        return TRUE;
    }
	
	/**
     * Sends a link to a user that lets them reset their password
     *
     * @param string $email    the user's email address
     * @param string $ver    the user's verification code
     * @return boolean        TRUE on success and FALSE on failure
     */
    private function sendResetEmail($email, $ver)
    {
        $e = sha1($email); // For verification purposes
        $to = trim($email);

        $subject = "[Colored Lists] Request to Reset Your Password";

        $headers = <<<MESSAGE
From: Colored Lists <donotreply@coloredlists.com>
Content-Type: text/plain;
MESSAGE;

        $msg = <<<EMAIL
We just heard you forgot your password! Bummer! To get going again,
head over to the link below and choose a new password.

Follow this link to reset your password:
http://coloredlists.com/resetpassword.php?v=$ver&e=$e

If you have any questions, please contact help@coloredlists.com.

--
Thanks!

EMAIL;

        return mail($to, $subject, $msg, $headers);
    }
?>