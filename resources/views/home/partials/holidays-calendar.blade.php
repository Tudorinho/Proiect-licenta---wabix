<div class="card" style="padding: 10px;">
    <div class="bg-subtle">
        <h2>Holidays</h2>
        <div id="holidays_calendar"></div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('holidays_calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: JSON.parse('{!! $holidays !!}'),
            });
            calendar.render();
        });
    </script>
@endpush
