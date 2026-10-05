<?php 
session_start(); 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 
    <title>NEXUS - Admin Panel</title> 
 
    <style> 
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: Arial, Helvetica, sans-serif; 
        } 
 
        body { 
            min-height: 100vh; 
            background: linear-gradient(135deg, #120018, #26002f, #4b075f); 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        } 
 
        .login-container { 
            width: 900px; 
            min-height: 520px; 
            background: #ffffff; 
            border-radius: 22px; 
            overflow: hidden; 
            display: flex; 
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.45); 
        } 
 
        /* LEFT SIDE */ 
        .left-section { 
            width: 48%; 
            background: linear-gradient(145deg, #4b075f, #72098f, #9d35b5); 
            color: white; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            padding: 40px; 
            text-align: center; 
        } 
 
        /* LOGO */ 
        .logo-container { 
            width: 120px; 
            height: 120px; 
            border-radius: 50%; 
            overflow: hidden; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin-bottom: 25px; 
            border: 2px solid rgba(255, 255, 255, 0.5); 
            background: #171717; 
        } 
 
        .logo-container img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            display: block; 
        } 
 
        .left-section h1 { 
            font-size: 48px; 
            letter-spacing: 5px; 
            margin-bottom: 8px; 
        } 
 
        .left-section p { 
            font-size: 16px; 
            opacity: 0.9; 
        } 
 
        /* RIGHT SIDE */ 
        .right-section { 
            width: 52%; 
            padding: 55px 60px; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
        } 
 
        .right-section h2 { 
            color: #4b075f; 
            font-size: 30px; 
            margin-bottom: 8px; 
        } 
 
        .subtitle { 
            color: #777; 
            margin-bottom: 30px; 
            font-size: 14px; 
        } 
 
        .input-group { 
            margin-bottom: 20px; 
        } 
 
        .input-group label { 
            display: block; 
            margin-bottom: 8px; 
            color: #333; 
            font-size: 14px; 
            font-weight: 600; 
        } 
 
        .input-group input { 
            width: 100%; 
            padding: 14px 16px; 
            border: 1px solid #ddd; 
            border-radius: 9px; 
            outline: none; 
            font-size: 15px; 
            transition: 0.3s; 
        } 
 
        .input-group input:focus { 
            border-color: #72098f; 
            box-shadow: 0 0 0 3px rgba(114, 9, 143, 0.12); 
        } 
 
        .login-btn { 
            width: 100%; 
            padding: 14px; 
            border: none; 
            border-radius: 9px; 
            background: linear-gradient(135deg, #5b0870, #8e20a8); 
            color: white; 
            font-size: 16px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: 0.3s; 
            margin-top: 8px; 
        } 
 
        .login-btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(91, 8, 112, 0.3); 
        } 
 
        .footer-text { 
            text-align: center; 
            margin-top: 25px; 
            color: #999; 
            font-size: 12px; 
        } 
 
        /* MOBILE */ 
        @media (max-width: 768px) { 
 
            .login-container { 
                width: 92%; 
                flex-direction: column; 
            } 
 
            .left-section { 
                width: 100%; 
                padding: 30px; 
                min-height: 220px; 
            } 
 
            .left-section h1 { 
                font-size: 38px; 
            } 
 
            /* MOBILE LOGO */ 
            .logo-container { 
                width: 90px; 
                height: 90px; 
                margin-bottom: 15px; 
            } 
 
            .right-section { 
                width: 100%; 
                padding: 35px 30px; 
            } 
        } 
    </style> 
</head> 
 
<body> 
 
    <div class="login-container"> 
 
        <!-- LEFT SIDE --> 
        <div class="left-section"> 
 
            <!-- NEXUS LOGO --> 
            <div class="logo-container"> 
                <img src="../client/assets/img/image (1).png" alt="NEXUS Logo"> 
            </div> 
 
            <h1>NEXUS</h1> 
            <p>Admin Panel</p> 
 
        </div> 
 
 
        <!-- RIGHT SIDE --> 
        <div class="right-section"> 
 
            <h2>Welcome Back</h2> 
 
            <p class="subtitle"> 
                Login to manage your NEXUS website 
            </p> 
 
            <form action="login.php" method="POST"> 
 
                <div class="input-group"> 
                    <label>Username</label> 
                    <input 
                        type="text" 
                        name="username" 
                        placeholder="Enter username" 
                        required 
                    > 
                </div> 
 
                <div class="input-group"> 
                    <label>Password</label> 
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Enter password" 
                        required 
                    > 
                </div> 
 
                <button type="submit" class="login-btn"> 
                    Login 
                </button> 
 
            </form> 
 
        </div> 
 
    </div> 
 
</body> 
</html>