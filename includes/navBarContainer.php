<div id="navBarContainer">
                <nav class="navBar">
                    <span tabindex="0" role="link" onclick="openPage('/');" class="logo">
                        <i class="fa fa-music"></i>
                    </span>
                    <div class="group">
                        <div class="navItem">
                            <span tabindex="0" role="link" onclick='openPage("search")' class="navItemLink">Search
                                <i class="fa fa-search icon"></i>
                            </span>
                        </div>
                    </div>
                    <div class="group">
                        <div class="navItem">
                            <span tabindex="0" role="link" onclick="openPage('browse');" class="navItemLink" >Browse</span>
                        </div>
                        <div class="navItem">
                            <span tabindex="0" role="link" onclick="openPage('yourmusic');" class="navItemLink" >Your music</span>
                        </div>
                        <div class="navItem">
                            <span tabindex="0" role="link" onclick="openPage('profile');" class="navItemLink" ><?php echo $userLoggedIn->getFullname() ?? ''; ?></span>
                        </div>
                    </div>
                </nav>
            </div>