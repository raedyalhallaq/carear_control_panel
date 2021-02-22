@extends('layout.master_layout')
@section('content')

    <div class="row mt-4">
        <div class="col-sm-2" style="color:#605f5f!important;font-size:1em;">
            <span class="fas fa-home"></span> <span>الرئيسية</span>
        </div>
        <div class="col-sm-2 ml-auto">
            <button class="btn btn-danger add_new font-weight-bold float-right"> اضافة جديد</button>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 table-data">
                @include('admin.services.paginate')
            </div>
        </div>
    </div>

    <div class="modal fade" id="control_user" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اضافة خدمة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body" >
                    <form class="row" id="person_form" method="post">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <div class="form-group row col-12">
                            <label for="" class="col-6">
                                العنوان
                                <input type="text"  class="form-control" name="title" id="title" >
                            </label>
                        </div>
                        <div class="form-group row col-12">
                            <label for="" class="col-6">
                                الوصف
                                <input type="text"  class="form-control" name="description" id="description">
                            </label>
                        </div>
                        <div class="form-group row col-12">
                            <label for="" class="col-6">
                                الايقونة
                                <input type="text"  class="form-control" name="icons" id="icons">
                            </label>
                        </div>
                        <div class="row col-6">
                            اللغة
                            <select name="lang row col-6" id="lang" class="form-control mt-1 mb-1">
                                <option value=""></option>
                                <option value="ar">عربي</option>
                                <option value="en">انجليزي</option>
                            </select>
                        </div>

                        <div class="row col-12">
                            <div class="col-12">
                                اضغط لاختيار الأيقونة
                            </div>
                            <div class="col-12 mt-2">
                                <span data-route="fas fa-id-card" class="fas fa-id-card icon" style="margin-right:1;font-size:3em;color: #6c712e;"></span>
                                <span data-route="fas fa-globe" class="fas fa-globe icon" style="margin-right:1;font-size:3em;color: #6c712e;"></span>
                                <span data-route="fas fa-map-marked-alt" class="fas fa-map-marked-alt icon" style="margin-right:1;font-size:3em;color: #6c712e;"></span>
                                <span data-route="fas fa-thumbs-up" class="fas fa-thumbs-up icon" style="margin-right:1;font-size:3em;color: #6c712e;"></span>
                                <span data-route="fab fa-telegram-plane" class="fab fa-telegram-plane icon" style="margin-right:1;font-size:3em;color: #6c712e;"></span>
                                <span data-route="fab fas fa-laptop-medical" class="fab fas fa-laptop-medical icon" style="margin-right:1;font-size:3em;color: #6c712e;"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary font-weight-bold" id="save">حفظ التغييرات</button>
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">اغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $("#image_preview").fadeOut()
        function fetchData(page){
            $.ajax({
                url:"/admin/services?page="+page,
                method:"get",
                dataType:'html',
                success:function (data){
                    $('.table-data').html('')
                    $('.table-data').append(data)
                }
            })
        }
        $(document).on('click','.pagination a',function(event){
            event.preventDefault()
            var page = $(this).attr('href').split('page=')[1];
            fetchData(page)
        })
        $(document).on('click','.add_new',function (){
            $("#title").val("")
            $("#description").val("")
            $("#id").val("")
           $("#icons").val("")
            $("#lang option[value='']")
            $('#control_user').modal('show')
        })
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name=csrf-token]').attr('content')
            }
        })
    </script>
    <script>
        $(document).on('click','#save',function (){
            let form = document.getElementById("person_form");
            let formDate = new FormData(form)
            let id = $("#id").val();
            if ($("#id").val() ==""){
                $.ajax({
                    url:'/admin/save/services',
                    method:'post',
                    data:formDate,
                    dataType:'json',
                    success:function (response){
                        if (response.status){
                            Swal.fire("تم الحفظ بنجاح", "success");

                        }
                        else {
                            Swal.fire("حدث خطأ","error")
                        }
                        fetchData(1);
                        $('#control_user').modal('hide')
                    },
                    error: function(response) {
                        $('#first_name_error').text(response.responseJSON.errors.first_name[0]);
                        $('#second_name_error').text(response.responseJSON.errors.second_name[0]);
                        $('#mother_name_error').text(response.responseJSON.errors.mother_name[0]);
                        $('#family_name_error').text(response.responseJSON.errors.family_name[0]);
                        $('#third_name_error').text(response.responseJSON.errors.third_name[0]);
                    },
                    contentType: false,
                    cache: false,
                    processData: false,

                })
            }
            else
            {
                $.ajax({
                    url: '/admin/service/' + id + "/update",
                    method: 'post',
                    data: formDate,
                    dataType: 'json',
                    success: function () {
                        Swal.fire("Good job!", "update");
                        fetchData(1)
                        $('#control_user').modal('hide')
                    },
                    error: function (response) {

                    },
                    contentType: false,
                    cache: false,
                    processData: false,

                })
            }


        })

    </script>

    <script>
        $(document).on('click','.update-person',function (){
            let id = $(this).attr('data-route')
            $.ajax({
                url:"/admin/service/"+id,
                method:'post',
                data:{},
                dataType:'json',
                success:function (response){
                    $("#title").val("")
                    $("#description").val("")
                    $("#icons").val("")

                    ///////////////////////
                    $("#id").val(id)
                    $("#title").val(response.data.title)
                    $("#description").val(response.data.description)
                    $("#icons").val(response.data.icons)
                    $("#control_user").modal('show')
                },
                contentType: false,
                cache: false,
                processData: false,
            })
        })
    </script>
    <script>
        $(document).on('click','.delete-person',function (){
            let item = $(this);
            Swal.fire({
                title: "هل أنت متأكد؟",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "نعم",
                cancelButtonText: "لأ!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    let id = item.attr('data-route')
                    $.ajax({
                        url:"/admin/service/"+id+"/delete",
                        method:'post',
                        data:{},
                        success:function (response){
                            if (response.status){
                                Swal.fire(
                                    "تم الحذف!",
                                    "تم حذف العنصر بنجاح",
                                    "success"
                                )
                            }else {
                                Swal.fire("العنصر غير موجود","error")
                            }
                            item.closest('tr').remove()
                        }

                    })

                    Swal.fire(
                        "تم الحذف!",
                        "تم حذف العنصر بنجاح",
                        "success"
                    )
                    // result.dismiss can be "cancel", "overlay",
                    // "close", and "timer"
                } else if (result.dismiss === "cancel") {
                    Swal.fire(
                        "Cancelled",
                        "Your are in safe :)",
                        "error"
                    )
                }
            });
        })
    </script>

    <script>
        $(document).on('click','.icon',function (){
            let icon = $(this).attr('data-route')
            $("#icons").val(icon)
        })
    </script>

@endsection
@section("css")
    <style>
        @media (min-width: 1024px){
            .modal-lg, .modal-xl {
                max-width: 50%!important;
            }
        }
    </style>
@endsection
