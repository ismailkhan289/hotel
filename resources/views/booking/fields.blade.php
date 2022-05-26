    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="room_id">Room</label>
        <div class="col-sm-10">
            <select name="room_id" class="form-control" id="room_id" required>
                @if(isset($booking->id))
                @foreach($rooms as $id => $display)
                    <option value="{{ $id }}"                     
                    {{($id===$booking->room_id)?'selected':''}}>
                   {{ $display }}                    
                @endforeach
                @else
                @foreach($rooms as $id => $display)
                    <option value="{{ $id }}">
                   {{ $display }}                    
                @endforeach
                @endif
            </select>
            <small class="form-text text-muted">The room number being booked.</small>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label"for="user_id">User</label>
        <div class="col-sm-10">
            <select name="user_id" class="form-control" id="user_id" required>
                @foreach($users as $id => $display)
                @if(isset($bookings_users->user_id))
                    <option value="{{ $id }}"                    
                    {{($id===$bookings_users->user_id)?'selected':''}}>                    
                    {{ $display }}</option>
                    @else
                    <option value="{{ $id }}">                    
                    {{ $display }}</option>
                    @endif
                @endforeach
            </select>
            <small class="form-text text-muted">The user booking the room.</small>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="start">Start Date</label>
        <div class="col-sm-10">
            @if(isset($booking->start))
            <input name="start" type="date" class="form-control" required placeholder="yyyy-mm-dd" value="{{$booking->start ??''}}"/>
            @else
            <input name="start" type="date" class="form-control" required placeholder="yyyy-mm-dd"/>
            @endif
            <small class="form-text text-muted">The start date for the booking.</small>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="start">End Date</label>
        <div class="col-sm-10">
            @if(isset($booking->end))
            <input name="end" type="date" class="form-control" required placeholder="yyyy-mm-dd" value="{{$booking->end??''}}" />
            @else
            <input name="end" type="date" class="form-control" required placeholder="yyyy-mm-dd"/>
            @endif
            <small class="form-text text-muted">The end date for the booking.</small>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-2">Paid Options</div>
        <div class="col-sm-10">
            <div class="form-check">
                @if(isset($booking->is_paid)&&($booking->is_paid!=0))
                <input name="is_paid" type="checkbox" class="form-check-input" value="1" {{
                    'checked'}} />
                @else
                <input name="is_paid" type="checkbox" class="form-check-input" value="1"/>
                @endif
                <label class="form-check-label" for="start">Pre-Paid</label>
                <small class="form-text text-muted">If the booking is being pre-paid.</small>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="notes">Notes</label>
        <div class="col-sm-10">
            <input name="notes" type="text" class="form-control" placeholder="Notes" 
            value="{{$booking->notes??''}}" />
            <small class="form-text text-muted">Any notes for the booking.</small>
        </div>
    </div>

    <input type="hidden" name="is_reservation" value="1"/>

    @csrf