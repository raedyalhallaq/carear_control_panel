@extends('layout.master_layout')
@section('content')

    <div class="row mt-4">
        <div class="col-sm-2" style="color:#605f5f!important;font-size:1em;">
            <span class="fas fa-home"></span> <span>الرئيسية</span>
        </div>
        @can("add_news")
        <div class="col-sm-2 ml-auto">
            <button class="btn btn-danger add_new font-weight-bold float-right"> اضافة جديد</button>
        </div>
        @endcan
    </div>
    <div class="row">
        <form class="col-sm-12 row ml-3" id="search_form" method="get">
            <input type="text" id="search" name="search" placeholder="ادخل كلمة البحث" class="form-control col-sm-3" />
        </form>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 table-data">
                @include('admin.news.paginate')
            </div>
        </div>
    </div>

    <div class="modal fade" id="control_user" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اضافة خبر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body" >
                    <form class="row" id="person_form" method="post">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <div class="row col-12 mr-5">
                            <img src="" style="width:150px;height:150px;" id="image_preview" alt="">

                        </div>
                        <div class="form-group row col-12">
                            <label for="" class="col-6">
                                صورة الخبر
                                <input type="file"  class="form-control" name="image" id="image" >
                            </label>
                        </div>

                        <div class="form-group row col-8">
                            <label for="" class="col-12">
                                العنوان
                                <input type="text"  class="form-control" name="title" id="title" >
                            </label>
                        </div>
                        <div class="form-group row col-8">
                            <label for="" class="col-12">
                                وصف قصير
                                <input type="text"  class="form-control" name="sub_description" id="sub_description" >
                            </label>
                        </div>
                        <label for="" class="form-group row col-12 pl-4">
                            <span class="mb-2">
                                تفاصيل الخبر
                            </span>
                              <textarea name="description"  class="form-control" id="editor2" rows="10" cols="40">
                                         </textarea>
                        </label>
                        <label for="" class="col-6 row">
                            اللغة
                            <select name="lang" class="col-12 form-control"  id="lang">
                                <option value=""></option>
                                <option value="ar">عربي</option>
                                <option value="en">English</option>
                            </select>
                        </label>

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
        CKEDITOR.replace( 'editor2' );
    </script>

    <script>
        $("#image_preview").fadeOut()
        function fetchData(page){
            $.ajax({
                url:"/admin/news?page="+page,
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
            $("#link").val("")
            $("#id").val("")
            $("#image_preview").fadeOut()
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
            var data = CKEDITOR.instances.editor2.getData()
            formDate.append('description',data);
            let id = $("#id").val();
            if ($("#id").val() ==""){
                $.ajax({
                    url:'/admin/save/news',
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
                    url: '/admin/news/' + id + "/update",
                    method: 'post',
                    data: formDate,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status){
                            Swal.fire("تم الحفظ بنجاح", "success");

                        }
                        else {
                            Swal.fire("حدث خطأ","error")
                        }
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
                url:"/admin/news/"+id,
                method:'post',
                data:{},
                dataType:'json',
                success:function (response){
                    $("#title").val("")
                    $("#link").val("")
                    $("#image").val("")
                    ///////////////////////////
                    $("#id").val(id)
                    $("#title").val(response.data.title)
                    $("#sub_description").val(response.data.sub_description)
                    CKEDITOR.instances.editor2.setData(response.data.description)
                    // $("#image").val(response.data.image)
                    $("#lang option[value='"+response.data.lang+"'"+ "]").prop('selected',true)
                    $("#image_preview").attr('src',"/uploads/"+response.data.image)
                    $("#image_preview").fadeIn()
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
                        url:"/admin/news/"+id+"/delete",
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
                        "تم الالغاء",
                        "أنت بأمان",
                        "error"
                    )
                }
            });
        })
    </script>

    <script>
        $('#search').on('input',function(e){
            let search = $('#search').val()
            $.ajax({
                url:"/admin/news?search="+search,
                method:'GET',
                data:{},
                dataType:'HTML',
                success:function (data){
                    $('.table-data').html('')
                    $('.table-data').append(data)
                },
                contentType: false,
                cache: false,
                processData: false,
            })
        });

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
