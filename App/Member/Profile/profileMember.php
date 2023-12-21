<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .id-ididid {
    background-color: #808080;
    color: white;
    padding: 20px;
    text-align: right;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000; /* Set a higher z-index value */
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.id-ididid a {
    color: black;
    text-decoration: none;
    margin: 0 10px;
    display: inline;
}

.profile-info {
    display: flex;
    align-items: center;
    margin-right: 10px;
}

.profile-info i {
    font-size: 2em; /* Adjust the font size as needed */
    margin-right: 5px; /* Adjust the margin as needed */
}



    </style>
</head>
<body>

<div class="id-ididid">
    <div class="profile-info" style="color: black; margin-left: 10px;">
        <?php
        // Check if the username is set in the session
        if (isset($_SESSION["namaMember"])) {
            // Display the username
            echo "Welcome, " . $_SESSION["namaMember"];
        }
        ?>
    </div>
    <i class="fa fa-circle-user fa-2x" style="color: black;"></i>
</div>