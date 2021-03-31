<form action ="{{ url('payments') }}" method ="POST">
    @csrf
    <table>
       <tr>
          <td>Name</td>
          <td><input type="text" name="payment_name"/></td>
       </tr>
    </table>
 </form>
 @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif