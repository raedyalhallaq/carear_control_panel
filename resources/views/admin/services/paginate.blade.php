<table class="table">
    <thead>
    <tr>
        <th width="5%">#</th>
        <th width="20%">العنوان</th>
        <th width="20%">الوصف</th>
        <th width="10%">الايقونة</th>
        <th width="5%">تعديل</th>
        <th width="5%">حذف</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 0;?>
    @foreach($items as $item)
        <tr>
            <th scope="row">{{++$i}}</th>
            <td>
               {{$item->title}}
            </td>

            <td>{{$item->description}} </td>
            <td >
                <span class="{{$item->icons}} text-xl-right"></span>
            </td>
            <td>
                @can('edit_service')
                <button class="btn btn-primary update-person" data-route="{{$item->id}}" style="border-radius: 50%;box-sizing: border-box;">
                    <span class="flaticon2-pen"></span>
                </button>
                @endcan
            </td>
            <td>
                @can("delete_service")
                <button class="btn btn-danger delete-person" data-route="{{$item->id}}" style="border-radius: 50%;box-sizing: border-box;">
                    <span class="flaticon2-trash"></span>
                </button>
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{$items->links()}}
