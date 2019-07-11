<div id="navbarContainer">
    <div class="navbar">

        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
            <img src="assets/images/icons/logo.png" alt="Application Logo">
        </span>

        <div class="group">
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('search.php')" class="navItemLink">
                    Seach
                    <img src="assets/images/icons/search.png" alt="Seach Image" class="icon">
                </span>
            </div>
        </div>

        <div class="group">
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Browse</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('user_music.php')"  class="navItemLink">Your Music</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('settings.php')"  class="navItemLink"><?php echo $userLoggedIn->getFirstNameAndLastName() ?></span>
            </div>
        </div>

    </div>
</div>