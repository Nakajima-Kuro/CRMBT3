<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {



?>

    <!doctype html>
    <html lang="en" class="no-js">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">

        <title>Online_meeting</title>

        <script src='https://meet.jit.si/external_api.js'></script>
    </head>

    <body>
        <div id="meeting" style="width: 100%; height: 100vh;"></div>
        <script>
            roomName = '<?php echo $_SESSION['roomName']; ?>';
            isAdmin = '<?php echo $_SESSION['isRoomAdmin']; ?>';
            const domain = 'meet.jit.si';
            const options = {
                roomName: roomName,
                parentNode: document.querySelector('#meeting')
            };
            api = new JitsiMeetExternalAPI(domain, options);
            api.on('readyToClose', function(){
                if(api.getNumberOfParticipants() == 0){
                    window.location.href = "meeting.php?endName=" + roomName;
                }
                else{
                    window.location.href = "meeting.php";
                }
            })
        </script>
    </body>

    </html>
<?php } ?>