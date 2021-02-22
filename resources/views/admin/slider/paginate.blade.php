<table class="table">
    <thead>
    <tr>
        <th width="5%">#</th>
        <th width="20%">صورة الخلفية</th>
        <th width="30%">العنوان</th>
        <th width="10%">الحالة</th>
        <th width="5%">تعديل</th>
        <th width="5%">حذف</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 0;?>
    @foreach($sliders as $item)
        <tr>
            <th scope="row">{{++$i}}</th>
          <td>
              <a href="{{asset('uploads/'."$item->image")}}" data-fancybox="gallery" data-caption="Caption #1">
                  <img src="{{asset('uploads/'."$item->image")}}" width="48px" height="48px" alt="" />
              </a>
          </td>

            <td>{{$item->title}} </td>
            <td><input type="checkbox" {{$item->status ==1 ?"checked":""}}> </td>
            <td>
                @can('edit_slider')
                <button class="btn btn-primary update-person" data-route="{{$item->id}}" style="border-radius: 50%;box-sizing: border-box;">
                    <span class="flaticon2-pen"></span>
                </button>
                @endcan
            </td>
            <td>
                @can("delete_slider")
                <button class="btn btn-danger delete-person" data-route="{{$item->id}}" style="border-radius: 50%;box-sizing: border-box;">
                    <span class="flaticon2-trash"></span>
                </button>
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{$sliders->links()}}
