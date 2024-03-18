@extends('Layout.main_dashboard')
@section('form_page')
<div class="w3-container" id="mainResult">
    <div id="send_sms_success"></div>
    <div class="alert-danger" id="send_sms_error"></div>
    <div class="card card-primary">
        @if(session()->has('Transaction_Response_user_add'))
            <div class="alert alert-success">
                {{ session()->get('Transaction_Response_user_add') }}
            </div>
            <script>
                // Refresh the page after a delay of 1.5 seconds
                setTimeout(function(){
                    location.reload();
                }, 1500); // 1500 milliseconds = 1.5 seconds 
            </script>
       @endif

        @if(session()->has('Transaction_Response_user_add_error'))
            <div class="alert alert-danger">
                {{ session()->get('Transaction_Response_user_add_error') }}
            </div>
            <script>
                // Refresh the page after a delay of 1.5 seconds
                setTimeout(function(){
                    location.reload();
                }, 1500); // 1500 milliseconds = 1.5 seconds 
            </script>
        @endif
        @if(session()->has('Transaction_Response_user_update'))
            <div class="alert alert-warning">
                {{ session()->get('Transaction_Response_user_update') }}
            </div>
            <script>
                // Refresh the page after a delay of 1.5 seconds
                setTimeout(function(){
                    location.reload();
                }, 1500); // 1500 milliseconds = 1.5 seconds 
            </script>
        @endif
        <form action="{{route('RegPrsInf')}}" method="POST">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label for="NameUser">نام و نام خانوادگی</label>
                <input type="text" class="form-control" name="NameUser" id="NameUser"  placeholder="نام و نام حانوادگی">
            </div>
            <div class="form-group">
                <label for="UserEmail">ایمیل: </label>
                <input type="text" class="form-control" name="UserEmail" id="UserEmail" placeholder="ایمیل">
            </div>
            <div class="form-group">
                <label for="UserMobile">موبایل( با صفر شروع شود)</label>
                <input type="text" class="form-control" id="UserMobile" name="UserMobile" placeholder="موبایل">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" id="reg_user_btn">ثبت اولیه مشتری</button>
        </div>
        </form>
        
    </div>
</div>

<div class="card card-primary" id="div_user_inf" style="width: 150%; " >
<div class="alert-success" style="display: none" id="msgSuccess"></div>
<div class="alert-danger" id="message_error" style="display: none"></div>
    <table class="table table-bordered" style="width: 100%" id="User_Inf_Table" name="User_Inf_Table">
        <tbody>
            <tr>
                <th>ردیف</th>
                <th>نام مشتری</th>
                <th>ایمیل</th>
                <th>موبایل</th>
                <th>عملیات</th>
            </tr>
          @php
            $row_index=1;   
          @endphp
         
         @foreach($fetched_user as $key=>$value)
             <tr>
                @php
                    $rowID=$row_index;
                @endphp

                     <td  class="column_name" data-column_name="Row_count"  >{{$row_index++}}</td>
                     <td contenteditable  class="column_name" data-column_name="Customer_Name" id="Customer_Name" > {{$value->NameUser}}  </td>
                     <td contenteditable  class="column_name" data-column_name="userEmail" id="userEmail">{{ $value->UserEmail}}</td>
                     <td contenteditable class="column_name" data-column_name="userMobile" id="userMobile" > {{$value->UserMobile}}  </td>
                     <td>
                            @if (($value->Status)==1)
                                <button type='button' class='btn btn-info btn-xs EnableDisableUser' id="{{$value->_id}}" >فعال </button>   
                            @else
                                <button type='button' class='btn btn-danger btn-xs EnableDisableUser' style="background-color: darkmagenta" id="{{$value->_id}}" >غیر فعال</button>                               
                            @endif

                            @if ($value->deleted_at)
                                    <button type='button' class='btn btn-warning btn-xs RestoreUser' style="background-color: aqua" id="{{$value->_id}}">بازیابی</button>
                                    <button type='button' class='btn btn-danger btn-xs deletePermanently' id="{{$value->_id}}">حذف دائم</button>   
                            @else
                                    <button type='button' class='btn btn-success btn-xs updateInf' id="{{$rowID}}_{{$value->_id}}" onclick="edit_userinf(this)" >بروزرسانی </button>
                                    <button type='button' class='btn btn-warning btn-xs deleteInfTemp' id="{{$value->_id}}">حذف موقت</button> 
                            @endif
                            
                            
                     </td>
             
             </tr>          
         @endforeach         
        </tbody>
    </table>
</div>
<script type="text/javascript">
    var _token = $('input[name="_token"]').val();
    function edit_userinf(TdPack) {// Edit Price Sell in Anbar Table
        // alert(TdPack);
        var packInfo=TdPack.id;
        let packUnzip=packInfo.split("_");// 0 is row id and 1 is product ID in table of DB
        let nameUser=document.getElementById("User_Inf_Table").rows[packUnzip[0]].cells[1].innerHTML;
        let emailUser=document.getElementById("User_Inf_Table").rows[packUnzip[0]].cells[2].innerHTML;
        let mobileUser=document.getElementById("User_Inf_Table").rows[packUnzip[0]].cells[3].innerHTML;

        let userID=packUnzip[1];
        $.ajax({    
             url:"{{ route('updateUserInf') }}",
            method:"POST",
            data:{
                nameUser:nameUser,
                emailUser:emailUser,
                mobileUser:mobileUser,
                userID:userID,
                _token:_token
            },
            success: function(data){ // What to do if we succeed
                if(data==123){
                    document.getElementById("msgSuccess").style.display="block";
                    document.getElementById("msgSuccess").innerHTML="بروزرسانی باموفقیت انجام شد";
                    setTimeout(function(){
                                        location.reload();
                                    }, 1000); // 1500 milliseconds = 1.5 seconds
                }
            },
            error: function(data){
                document.getElementById("ModalResponse").style.display="block";
                document.getElementById("message_error").innerHTML="خطایی در سیستم رخ داده است لطفا دوبار نلاش نمایید.";
            }
        });



    }

    $(document).on('click', '.EnableDisableUser', function() {

        userID=this.id;
        // console.log({
        //     "userID":userID
        // })
        $.ajax({    
             url:"{{ route('EnableDisableUser') }}",
            method:"POST",
            data:{
                userID:userID,
                _token:_token
            },
            success: function(data){ // What to do if we succeed
                if(data==123){
                    document.getElementById("msgSuccess").style.display="block";
                    document.getElementById("msgSuccess").innerHTML="بروزرسانی باموفقیت انجام شد";
                    setTimeout(function(){
                                        location.reload();
                                    }, 1000); // 1500 milliseconds = 1.5 seconds
                }
            },
            error: function(data){
                document.getElementById("message_error").style.display="block";
                document.getElementById("message_error").innerHTML="خطایی در سیستم رخ داده است لطفا دوبار نلاش نمایید.";
            }
        });



    })
$(document).on('click', '.deleteInfTemp', function() {
        userID=this.id;
        // console.log({
        //     "userID":userID
        // })
        $.ajax({    
            url:"{{ route('DeleteUserTemp') }}",
            method:"POST",
            data:{
                userID:userID,
                _token:_token
            },
            success: function(data){ // What to do if we succeed
                if(data==123){
                    document.getElementById("msgSuccess").style.display="block";
                    document.getElementById("msgSuccess").innerHTML="'کاربر موقتا حذف شد";
                    setTimeout(function(){
                                        location.reload();
                                    }, 1000); // 1500 milliseconds = 1.5 seconds
                }
            },
            error: function(data){
                document.getElementById("message_error").style.display="block";
                document.getElementById("message_error").innerHTML="خطایی در سیستم رخ داده است لطفا دوبار نلاش نمایید.";
            }
        });



})

$(document).on('click', '.RestoreUser', function() {
        userID=this.id;
        // console.log({
        //     "userID":userID
        // })
        $.ajax({    
            url:"{{ route('RestoreUser') }}",
            method:"POST",
            data:{
                userID:userID,
                _token:_token
            },
            success: function(data){ // What to do if we succeed
                if(data==123){
                    document.getElementById("msgSuccess").style.display="block";
                    document.getElementById("msgSuccess").innerHTML="کاربر بروز رسانی شد.";
                    setTimeout(function(){
                                        location.reload();
                                    }, 1000); // 1500 milliseconds = 1.5 seconds
                }
            },
            error: function(data){
                document.getElementById("message_error").style.display="block";
                document.getElementById("message_error").innerHTML="خطایی در سیستم رخ داده است لطفا دوبار نلاش نمایید.";
            }
        });



})

$(document).on('click', '.deletePermanently', function() {
        userID=this.id;
        // console.log({
        //     "userID":userID
        // })
        $.ajax({    
            url:"{{ route('deletePermanently') }}",
            method:"POST",
            data:{
                userID:userID,
                _token:_token
            },
            success: function(data){ // What to do if we succeed
                if(data==123){
                    document.getElementById("msgSuccess").style.display="block";
                    document.getElementById("msgSuccess").innerHTML="کاربر به طور کامل حذف شد.";
                    setTimeout(function(){
                                        location.reload();
                                    }, 1000); // 1500 milliseconds = 1.5 seconds
                }
            },
            error: function(data){
                document.getElementById("message_error").style.display="block";
                document.getElementById("message_error").innerHTML="خطایی در سیستم رخ داده است لطفا دوبار نلاش نمایید.";
            }
        });



})
</script>
@endsection