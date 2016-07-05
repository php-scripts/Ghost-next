// js callbacks for index page

    function feedback() {
       window.open('feedback.php', '', 'resizable=no, location=no, width=300, height=400, menubar=no, status=no, scrollbars=yes, menubar=no');
    }

    function log_adapt(){
		conversation = document.getElementById("ghost-log");
        conversation.scrollTop = conversation.scrollHeight;
    }
