import loadash from 'lodash'
window._ = loadash

import './axios';

// import * as Popper from '@popperjs/core'
// window.Popper = Popper

// import bootstrap scss
import '../scss/app.scss'

// bootstrap not working with tooltip < do not uncomment this >
// import * as bootstrap from 'bootstrap'
// window.bootstrap = bootstrap;

// moment
import moment from 'moment';
import * as MomentRange from 'moment-range';
const momentJs = MomentRange.extendMoment(moment);
window.moment = momentJs;

// fullcalendar
import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid'
import dayGridPlugin from '@fullcalendar/daygrid';
import multiMonthPlugin from '@fullcalendar/multimonth'
import momentPlugin from '@fullcalendar/moment'
import bootstrap5Plugin from '@fullcalendar/bootstrap5'
window.Calendar = Calendar;
window.timeGridPlugin = timeGridPlugin;
window.dayGridPlugin = dayGridPlugin;
window.multiMonthPlugin = multiMonthPlugin;
window.momentPlugin = momentPlugin;
window.bootstrap5Plugin = bootstrap5Plugin;

// chartjs
import Chart from 'chart.js/auto';
import { getRelativePosition } from 'chart.js/helpers';
window.Chart = Chart;

// import jQuery from 'jquery';
import $ from 'jquery/dist/jquery';
window.jQuery = window.$ = $;

// select2
import select2 from 'select2'
select2();

// sweetalert2
import swal from "sweetalert2";
window.swal = swal;

// DataTablesBootstrap5.net
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import 'datatables.net-autofill-bs5';
import Buttons from 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.colVis.mjs';
import ButtonsHTML5 from 'datatables.net-buttons/js/buttons.html5.mjs';
import print from 'datatables.net-buttons/js/buttons.print.mjs';
import 'datatables.net-colreorder-bs5';
import 'datatables.net-fixedheader-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-rowgroup-bs5';
import 'datatables.net-rowreorder-bs5';
import pdfMake from 'pdfmake/build/pdfmake';
// import pdfFonts from 'pdfmake/build/vfs_fonts';
// cant compile with vite
// PDF button will produce below error
// Uncaught (in promise) File 'Roboto-Regular.ttf' not found in virtual file system
import PdfPrinter from 'pdfmake';
import JsZip from 'jszip';
window.JSZip = JsZip;
// pdfMake.vfs = pdfFonts.pdfMake.vfs;
// DataTable.use(DataTablesCore, pdfMake, PdfPrinter, pdfFonts, Buttons, ButtonsHTML5, JsZip);
DataTable.use(DataTablesCore, pdfMake, PdfPrinter, Buttons, ButtonsHTML5, JsZip);

// jquery-chained -- cant make it work
// import "../../node_modules/jquery-chained/jquery.chained";
// import "../../node_modules/jquery-chained/jquery.chained.remote";
// window.chainedTo = chainedTo;

// jquery-ui
// import '../../node_modules/jquery-ui/dist/jquery-ui.js'

// jqueryMinicolors -> got error of undefine properties
// import minicolors from '@claviska/jquery-minicolors/jquery.minicolors';
// window.minicolors = minicolors;

//////////////////////////////////////////////////////////////////////////////////////////////////////////
// vue components
//////////////////////////////////////////////////////////////////////////////////////////////////////////
