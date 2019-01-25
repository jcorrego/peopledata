<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title"><a href="/courses/{{ $course->id }}/students">{{ $course->name }}</a></h5>
        @if($course->professor)
            <small class="text-info">{{ $course->professor->first_name }} {{ $course->professor->last_name }}</small>
        @endif
        <p class="card-text">
            @if($course->hour != '12:00 am')
                <span>{{ $course->hour }}</span><br>
            @endif
            {{ $course->location }}<br>
            @if($course->value)
                <span class="text-muted">${{ number_format($course->value,0,',','.') }}</span> <br>
            @endif
            @if($course->members->whereNotIn('pivot.status',['didnt_start','didnt_finish'])->count())
            <span class="badge badge-info">{{ $course->members->whereNotIn('pivot.status',['didnt_start','didnt_finish'])->count() }} estudiantes</span>
            @endif
        </p>
    </div>
</div>