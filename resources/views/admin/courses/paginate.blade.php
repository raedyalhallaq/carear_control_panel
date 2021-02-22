<table class="table">
    <thead>
    <tr>
        <th width="5%">#</th>
        <th width="20%">صورة الخلفية</th>
        <th width="30%">المحتوى</th>
        <th width="5%">تعديل</th>
        <th width="5%">حذف</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 0;?>
    @foreach($items as $item)
        <tr>
            <th scope="row">{{++$i}}</th>
            <td>{{$item->title}} </td>
            <td>{!! $item->content !!} </td>
            <td>
                @can("edit_course")
                <button class="btn btn-primary update-person" data-route="{{$item->id}}" style="border-radius: 50%;box-sizing: border-box;">
                    <span class="flaticon2-pen"></span>
                </button>
                @endcan
            </td>
            <td>
                @can("delete_course")
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
