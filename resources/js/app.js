// Default Laravel bootstrapper, installs axios, jQuery
import './bootstrap';

// Added: Popper.js dependency for popover support in Bootstrap
// import '@popperjs/core';

// jquery-ui
// import '../../node_modules/jquery-ui/dist/jquery-ui';
import './jquery-ui-prefix';

// careful between these 2 (bootstrap and jquery-ui), cause it conflicts on "tooltips". this way, we override all components from jquery-ui which results we always use the bootstrap components.
// Added: Actual Bootstrap JavaScript dependency
import '../../node_modules/bootstrap/dist/js/bootstrap.bundle';

// select2
import select2 from 'select2';
select2();

// sweetalert2
import swal from 'sweetalert2';
window.swal = swal;

// moment
import moment from 'moment';
window.moment = moment;

// datatables
import DataTable from 'datatables.net';
import 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-fixedheader-bs5';
import 'datatables.net-colreorder-bs5';
import 'datatables.net-autofill-bs5'
window.DataTable = DataTable;

// minicolors
import '@claviska/jquery-minicolors';

// Chart.js
import Chart from 'chart.js/auto';
window.Chart = Chart;

// @fullcalendar
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import multiMonthPlugin from "@fullcalendar/multimonth";
import listPlugin from '@fullcalendar/list';
import momentPlugin from '@fullcalendar/moment';
import bootstrap5Plugin from '@fullcalendar/bootstrap5';
window.Calendar = Calendar;
window.multiMonthPlugin = multiMonthPlugin;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;
window.momentPlugin = momentPlugin;
window.bootstrap5Plugin = bootstrap5Plugin;

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
