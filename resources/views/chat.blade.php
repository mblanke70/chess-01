<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>chess88</title>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/chat.css') }}">
        
    </head>
    <body>
       
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row container d-flex justify-content-center">
                    <div class="col-md-4">
                        <div class="box box-warning direct-chat direct-chat-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Chat Messages</h3>
                                <div class="box-tools pull-right"> <span data-toggle="tooltip" title="" class="badge bg-yellow" data-original-title="3 New Messages">20</span> <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button> <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts"> <i class="fa fa-comments"></i></button> <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i> </button> </div>
                            </div>

                            <div class="box-footer">
                                <!--<form action="" method="post">-->
                                    @csrf
                                    <div class="input-group"> 
                                        <input type="text" id="newMessage" name="message" placeholder="Type Message ..." class="form-control">
                                        <span class="input-group-btn"> 
                                            <!--<button type="submit" class="btn btn-warning btn-flat">Send</button>-->
                                            <button onclick="addMessage()" class="btn btn-warning btn-flat">Send</button>
                                        </span>
                                    </div>
                                <!--</form>-->
                            </div>

                            <div class="box-body">
                                <div id="messages" class="direct-chat-messages">

                                <!--
                                    <div class="direct-chat-msg right">
                                        <div class="direct-chat-info clearfix"> <span class="direct-chat-name pull-right">Sarah Bullock</span> <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span> </div> <img class="direct-chat-img" src="https://img.icons8.com/office/36/000000/person-female.png" alt="message user image">
                                        <div class="direct-chat-text"> Thank you for your believe in our supports </div>
                                    </div>
                                -->

                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>

        <script>

            var messages;

            Echo.channel('chat')

                .listen('MessageSent', (e) => 
                    
                    //console.log('MessageSent: ' + e.message.message);

                    document.getElementById('messages').insertAdjacentHTML(
                        "afterbegin", 
                        "<div class='direct-chat-msg'><div class='direct-chat-info clearfix'><span class='direct-chat-name pull-left'>" + e.user.name + "</span> <span class='direct-chat-timestamp pull-right'>" + e.message.created_at + "</span></div><img class='direct-chat-img' src='https://img.icons8.com/color/36/000000/administrator-male.png' alt='message user image'><div class='direct-chat-text'>" + e.message.message + "</div></div>"
                    )
            
                );

            function addMessage(message) {

                var newMessage = document.getElementById('newMessage').value;

                axios.post('./messages', { 
                    
                    message: newMessage 
                
                }).then(response => {
                
                    console.log(response.data);
                
                }).catch(function(error) {
                    
                    console.log(error.response.data);

                });

                document.getElementById('newMessage').value = '';

            }

            function fetchMessages() {

                axios.get('./messages').then(response => {
                
                    messages = response.data;

                    var html = "";
                
                    Object.values(messages).forEach(val => 
                        html =  "<div class='direct-chat-msg'><div class='direct-chat-info clearfix'><span class='direct-chat-name pull-left'>" + val.user.name + "</span> <span class='direct-chat-timestamp pull-right'>" + val.created_at + "</span></div><img class='direct-chat-img' src='https://img.icons8.com/color/36/000000/administrator-male.png' alt='message user image'><div class='direct-chat-text'>" + val.message + "</div></div>" + html
                    );

                    document.getElementById('messages').innerHTML = html;
                
                })
            
            }

            fetchMessages();

</script>

    </body>
</html>
