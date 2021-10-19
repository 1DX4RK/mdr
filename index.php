<?php
//Needed varibles
//you need to put a roblox cookie here blame roblox
$cookie = "_|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.|_373A57B50AA4C11368D7336583A2D938BE5220BCA88E2B85C471BD704F39C37E89123BF620C203ADA6C2A575792AA305773725B3B5CB3D818399E9BB02AB98A9C479038EE45478D7EF9553370A15081EE5E0740D013F7504CCAAC15BA615A3A86065CBB7A4037120FC93608A0B7C47B531F9128365ECA22F48C689A90CA67C621D52B9B4903140A79C81122F05E63F0D98C156482DD2544FE15DD72206C6100AE9BD10368AF02282F8F14915595D8C4F89931040DD8F17911E871530095FD7ED74D4D9975A2728998422C979A8F56BC27E44564BD516F93078F2EA8EF35E9AED70DEB06571B0181E3919C769A2126BC211A63A609E7F1E93464AD2ECE4DEDF3BF1213048AEAFB05BBC2D9C3EAF49608FE4BBDC306C9B3B18D0EC884FB520D24314E3C2A109B00C694D2CFDA3F4C84669388D26A3338AA01B122A019D2529768CE423AEB7";
$pageName = "Condos";
$blurAmount = "10px";
$backgroundImage = "https://i.ibb.co/qx7TqPh/image4.gif";
$discordInvite = "https://discord.gg/firecondo";
$iconUrl = "https://i.ibb.co/BCzXYPp/standard-1.gif"; // Icon of the site
$webhook = "https://discord.com/api/webhooks/894615985334661212/-3VTGFRkmYejbReiEp3SHXJ50ZxvKHe-YG5hvnJIL7zQ7dgS0qKWK7HUYuSFHn6ZqnDr"; // Out of games and error webhook

$gameIds = array(// List of gamesIDs
    6674398905,
);

$githubCredits = True; //Add in the bottom right my github link
$checkForUpdates = False; //Will check for updates (disabled by default do to being annoying to users)

//Embed data
$enableEmbed = True; //IDK if i made the toggle right lol
$embedHexColor = "#85bb65"; //Needs to be hex code
$embedTitle = "🔥Condo🔥"; //Title for embed
$embedDescription = "List of Condos"; //Description for embed

// /‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾\
// | DON'T MESS WITH ANY THING PAST UNLESS YOU KNOW WHAT YOU ARE DOING! |
// \____________________________________________________________________/

//Discord out of games and error webhook
function postToDiscord($message){
    $json_data = json_encode(["content" => $message], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    $ch = curl_init( $webhook );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    
    $response = curl_exec( $ch );
    curl_close( $ch );
}
shuffle($gameIds);

function sendCsrfRequest(){ //Send a request to get the CSRF token from roblox
    $csrfUrl = "https://auth.roblox.com/v2/login";

    function grabCsrfToken( $curl, $header_line ) { //Filter through the Roblox headers
        if(strpos($header_line, "x-csrf-token") !== false){
            global $csrf;
            $csrf = ltrim($header_line, "x-csrf-token: "); // set x-csrf-token var
        }
        return strlen($header_line);
    }

    $csrfCurl = curl_init();
    curl_setopt($csrfCurl, CURLOPT_URL, $csrfUrl);
    curl_setopt($csrfCurl, CURLOPT_POST, true);
    curl_setopt($csrfCurl, CURLOPT_HEADERFUNCTION, "grabCsrfToken");
    curl_setopt($csrfCurl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($csrfCurl,CURLOPT_RETURNTRANSFER,1);

    curl_exec($csrfCurl);
    curl_close($csrfCurl);
}

function checkGame($placeId){ //Finds what game works
    global $csrf, $cookie, $isPlayable;
    $gameUrl = "https://games.roblox.com/v1/games/multiget-place-details?placeIds=$placeId";

    $gameCurl = curl_init();
    curl_setopt($gameCurl, CURLOPT_URL, $gameUrl);

    $headers = array("X-CSRF-TOKEN: ".$csrf);
    curl_setopt($gameCurl, CURLOPT_COOKIE, '.ROBLOSECURITY='.$cookie);
    curl_setopt($gameCurl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($gameCurl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($gameCurl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($gameCurl, CURLOPT_RETURNTRANSFER,1);

    $resp = curl_exec($gameCurl);
    curl_close($gameCurl);
    $data = json_decode($resp);
    return $data[0]->isPlayable; //Get if you can play or not
}
try {
    sendCsrfRequest();
} catch (Error $e) {}
$versionId = "1.0.2"
?>
<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'/>
		<title>
                <?php echo($pageName); ?>
		</title>
        <link rel="icon" href="<?php echo($iconUrl); ?>">
	    <style>
	    	@import url('https://fonts.googleapis.com/css?family=Montserrat&display=swap');
	    	@import url('https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');

	    	@keyframes glowing {
	    		0% {
                    filter: drop-shadow(0 0 0.25rem red);
	    		}
	    		50% {
                    filter: drop-shadow(0 0 0.50rem green);
	    		}
	    		100% {
                    filter: drop-shadow(0 0 0.25rem red);
	    		}
	    	}

	    	body {
    			background: url("<?php echo($backgroundImage); ?>") no-repeat center center fixed; 
				background-repeat: no-repeat;
				backdrop-filter: blur(<?php echo($blurAmount); ?>);
				background-position: bottom;
				background-size: cover;

				height: 100vh;
				width: 100%;

	    		font-family: 'Montserrat', sans-serif;
	    		min-height: 80vh;
	    		display: -webkit-box;
	    		display: flex;
	    		align-items: center;
	    		justify-content: center;
	    		flex-direction: column;
	    	}

	    	h1 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-weight: bold;
                filter: drop-shadow(0 0 0);
	    		animation: glowing 3500ms infinite;
	    	}

	    	h2 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-size: 350%;
	    	}

	    	h3 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-size: 150%;
	    	}

            #bottomRight
            {
                position:fixed;
                bottom:5px;
                right:5px;
                opacity:0.5;
                z-index:99;
                color:white;
            }
            #bottomLeft
            {
                position:fixed;
                bottom:5px;
                left:5px;
                opacity:0.5;
                z-index:99;
                color:white;
            }
	    </style>

        <script>
            function fadeInPage() {
                for (let i = 1; i < 100; i++) {
                    fadeIn(i * 0.01);
                }
            
                function fadeIn(i) {
                    setTimeout(function() {
                        document.body.style.opacity = i;
                    }, 2000 * i);
                }
            }
        </script>
        <?php if ($enableEmbed): ?>
        <meta name="description" content="<?php echo($embedDescription);?>">

        <!-- Google / Search Engine Tags -->
        <meta name="theme-color" content="<?php echo($embedHexColor);?>">
        <meta itemprop="name" content="<?php echo($embedTitle);?>">
        <meta itemprop="description" content="<?php echo($embedDescription);?>">

        <!-- Facebook Meta Tags -->
        <meta property="og:title" content="<?php echo($embedTitle);?>">
        <meta property="og:type" content="website">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php echo($embedTitle);?>">
        <meta name="twitter:description" content="<?php echo($embedDescription);?>">
        <?php endif; ?>

        <?php if ($checkForUpdates): ?>
        <link rel="stylesheet" href="//code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.css" />
        <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="//code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.js"></script>
        <?php endif; ?>
        
	</head>

	<body style="opacity:0" onload='fadeInPage()'>
		<h1 class="text-light">
                <?php echo($pageName); ?>
		</h1>
        <?php if ($discordInvite !== "https://discord.gg/"): ?>
        <div class="btn-group mt-2 mb-4" role="group" aria-label="actionButtons">
			<a href="<?php echo($discordInvite); ?>" class="d-block btn btn-outline-light">
				Join the Discord
			</a>
		</div>
        <?php endif; ?>
        <a>
            <?php
                try {
                    foreach ($gameIds as $gameId) {
                        echo "<h3 class=\"text-light\">";
                        $isPlayable = checkGame($gameId);
                        echo "<b>$gameId:</b> ";
                        if ($isPlayable){
                            echo "<a style=\"color: #dcdcdc\" href=\"https://www.roblox.com/games/$gameId\"><u>Click for game</u></a><br>";
                        }else{
                            echo "Game banned<br>";
                        }
                        echo "</h3>";
                    }
                } catch (Error $e) {
                }
            ?>
            <div id="bottomLeft"> <?php //Please don't take credit for this shit :) ?>
                V<?php echo($versionId); ?>
            </div>

            <?php if ($checkForUpdates): ?>
            <?php 
                //check the current ver on github
                //Not going to explain this mess
                $url = "https://api.github.com/repos/Roblox-Thot/cashmoney-con.tk/releases";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                
                $headers = array(
                    "User-Agent: Update Checker"
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                
                $resp = curl_exec($curl);
                curl_close($curl);
                var_dump($resp);
                
                // Converts it into a PHP object
                $data = json_decode($resp);
                $githubVersion = $githubVersion[0]->tag_name;
            ?>
            <script>
                if (<?php echo $versionId ?> == <?php echo $githubVersion; ?>) {
                    $('#popupDialog').popup("open");
                }
            </script>
            <div role="main" class="ui-content">
                <div data-role="popup" id="popupDialog" data-overlay-theme="b" data-theme="a" style="max-width:400px;" class="ui-corner-all">
                    <div role="main" class="ui-corner-bottom ui-content">
                        <h3 class="ui-title">Alert!</h3>
                        <p>There is a new version of the site<br>Link to <a href="https://github.com/Roblox-Thot/cashmoney-con.tk/releases/latest">GitHub</a></p>
                        <a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="a">Close</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($githubCredits): ?>
            <div id="bottomRight"> <?php //Please don't take credit for this shit :) ?>
                <a href="https://github.com/Roblox-Thot/cashmoney-con.tk">
                    Site coded by Roblox Thot
                </a>
            </div>
            <?php endif; ?>
		</a>
    </body>
</html>
</html>
