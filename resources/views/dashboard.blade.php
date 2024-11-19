<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Dashboard') }}
		</h2>
	</x-slot>
	<div class="col-sm-12 justify-content-center">
		<div id='calendar'></div>
	</div>

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// fullcalendar
const calendarEl = document.getElementById('calendar')
const calendar = new FullCalendar.Calendar(calendarEl, {
	// plugins: [
	// 	timeGridPlugin,
	// 	dayGridPlugin,
	// 	multiMonthPlugin,
	// 	momentPlugin,
	// 	bootstrap5Plugin
	// ],
	aspectRatio: 1.0,
	height: 2000,
	weekNumbers: true,
	themeSystem: 'bootstrap',
	initialView: 'multiMonthYear',
	// initialView: 'dayGridMonth',
	headerToolbar: {
		left: 'prev,next today',
		center: 'title',
		// right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
		right: 'multiMonthYear,dayGridMonth,timeGridWeek'
	},
	events: {
		url: '{{ route('loancalendar') }}',
		method: 'GET',
		extraParams: {
			_token: '{!! csrf_token() !!}',
		},
	},
	failure: function() {
		alert('There was an error while fetching loan!');
	},
	// events: [
	// 			{
	// 				title: 'Test Calendar',
	// 				start: '{{ now() }}',
	// 				end: '{{ now() }}',
	// 				// url: route('hrleave.show', $v->id),
	// 				allDay: true,
	// 				// extendedProps: {
	// 				// 						department: 'BioChemistry'
	// 				// 					},
	// 				description: 'Test Tooltips',
	// 				color: 'teal',
	// 				textColor: 'yellow',
	// 				borderColor: 'green',
	// 			}
	// ],
	eventDidMount: function(info) {
		$(info.el).tooltip({
			title: info.event.extendedProps.description,
			placement: 'top',
			trigger: 'hover',
			container: 'body'
		});
	},
	eventTimeFormat: { // like '14:30:00'
		hour: '2-digit',
		minute: '2-digit',
		second: '2-digit',
		hour12: true
	}
})
calendar.render()

/////////////////////////////////////////////////////////////////////////////////////////
@endsection
</x-app-layout>
