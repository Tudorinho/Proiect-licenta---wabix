<div class="card" style="padding: 10px;">
    <div class="bg-subtle">
        <h2>Leaves</h2>
        <div id="calendar"></div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: JSON.parse('{!! $leaves !!}')
            });
            calendar.render();
        });
    </script>
@endpush
