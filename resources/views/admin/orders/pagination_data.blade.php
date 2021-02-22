<table class="table table-bordered table-striped table-condensed flip-content">
    <thead class="flip-content">
    <tr>
        <th width="20%"> الاسم </th>
        <th width="20%" class="numeric">الايميل </th>
        <th width="15%">الكورس</th>
        <th width="5%">حذف</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $row)
        <tr id="row{{$row->id}}">
            <td> {{$row->username}} </td>
            <td>{{$row->email}} </td>
            <td>{{$row->courseName}} </td>
            <td><button class="btn btn-danger delete-row" data-item="{{$row->id}}" ><span class="fa fa-trash"></span></button></td>
        </tr>
    @endforeach
    </tbody>
</table>


