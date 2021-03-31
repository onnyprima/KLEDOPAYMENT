<html>
    <head>
      <title>Payment</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </head>
    <body>
        <h1>Payments</h1>

        <form action ="{{ url('payments') }}" method ="POST">
            @csrf
            <table>
               <tr>
                  <td>Name</td>
                  <td><input type="text" name="payment_name"/></td>
                  <td> <button class="btn btn-info">Create</button></td>
               </tr>
            </table>
         </form>
         @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                  @endif

                  @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
          <table class="table table-bordered">
            <tr>
                <th width="20px" class="text-center">No</th>
                <th>Payment Name</th>
                <th width="280px"class="text-center">Delete</th>
            </tr>
            <?php 
            $i = 0; 
            $ids = [];
            ?>
            @foreach ($data as $post)
            <?php 
              array_push($ids, $post->id); 
            ?>
            <tr>
                <td class="text-center">{{ ++$i }}</td>
                <td id={{'row_'.$post->id}}>{{ $post->payment_name }}</td>
                <td class="text-center">
                    <input class="chk" type="checkbox" checked class="form-check-input" value={{$post->id}}>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="row">
          <div class="col"></div>
          <div class="col"></div>
          <div class="col"></div>
          <div class="col"></div>
          <div class="col"></div>
          <div class="col">
            <button id="delete" class="btn btn-danger">Delete</button>
          </div>
        </div>
        
        <div id="infodelete"></div>

        <a href="#notifications-panel" class="dropdown-toggle" data-toggle="dropdown">
            <i data-count="0" class="glyphicon glyphicon-bell notification-icon"></i>
          </a>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script type="text/javascript">
            Pusher.logToConsole = true;
      
            var pusher = new Pusher('50d1e0511004aaa9e419', {
              encrypted: true,
              cluster: 'ap1'
            });
      
            // Subscribe to the channel we specified in our Laravel Event
            var channel = pusher.subscribe('delete-payment');

            channel.bind('event-delete', function(data) {
                console.log(data); 
                $( "#infodelete" ).text(data.message);
                $("#row_" + data.id).css('background-color', 'red');
            });

            var callback = function(eventName, data) {
            console.log(`bind global: The event ${eventName} was triggered with data ${JSON.stringify(data)}`);
            };
            //bind to all events on the connection
            pusher.bind_global(callback);

            $('.chk').on('click', function(e){
              e.preventDefault();
            })

            $('#delete').on('click', function(){
              var jqueryarray = <?php echo json_encode($ids); ?>;
              console.log(jqueryarray);
              $( "#infodelete" ).text('Processing...');
              $.ajax({
                  type:'POST',
                  url:'/payments/delete',
                  data: {data: jqueryarray}, 
                  success:function(data){
                      alert('Data dalam proses hapus.');
                  },
                  error: function(e){
                      console.log(e)
                  }
              });
            })
          </script>
    </body>

 
    {!! $data->links() !!}
</html>