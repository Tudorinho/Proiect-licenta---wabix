<div class="card" style="padding: 10px;">
    <div class="bg-subtle">
        <h2>Events</h2>
        <div id="events_calendar"></div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('events_calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: JSON.parse('{!! $events !!}'),
            });
            calendar.render();
        });
    </script>
@endpush
