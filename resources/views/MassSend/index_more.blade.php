
    @forelse($wx_array as $value)
<tr>
    <th> <input type="checkbox"  id="wxinfo_table_check" name="checkbox" value="{{$value->page_id}}" style="width: 18px; height: 18px;" /></th>
    <th> <span><a href="{{url('webpage/search/')."/".$value->page_id}}" target="_blank"> {{$value->page_id}}</a></span></th>
    <th> <span>{!!$value->NickName!!}</span></th>
    <th> <span>{!!$value->RemarkName!!}</span></th>
    <th> <span>{{$value->Province}}</span></th>
    <th> <span>{{$value->City}}</span></th>
    <th> <span>{{$value->page_title}}</span></th>
    <th> <span>{{$value->create_time}}</span></th>
    <th>
        <span><a href="javascript:void(0)" onclick="WebPageDelete('{{$value->page_id}}')" data-id="{{$value->id}}">发送</a> </span>

    </th>

</tr>
        @empty
        @endforelse
