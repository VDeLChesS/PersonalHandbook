import { startStimulusApp } from "@symfony/stimulus-bundle";
import HelloController from "../assets/controllers/hello_controller";
import $ from "jquery";
import "evo-calendar";
import "evo-calendar/dist/evo-calendar.css";
import "evo-calendar/dist/evo-calendar.midnight-blue.css";
import "evo-calendar/dist/evo-calendar.midnight-blue.min.css";
import "evo-calendar/dist/evo-calendar.min.css";
import "evo-calendar/dist/evo-calendar.min.js";
import "evo-calendar/dist/evo-calendar.js";
import "evo-calendar/dist/evo-calendar.min.js.map";
import "evo-calendar/dist/evo-calendar.js.map";
import Calendar from "../assets/controllers/calendar_controller";

const app = startStimulusApp();
// register any custom, 3rd party controllers here
app.register("hello", HelloController);
app.register("calendar", Calendar);
// start Stimulus
app.start();
// import $ from "jquery";
// import "evo-calendar";
// import "evo-calendar/dist/evo-calendar.css";
// import "evo-calendar/dist/evo-calendar.midnight-blue.css";
// import "evo-calendar/dist/evo-calendar.midnight-blue.min.css";
// import "evo-calendar/dist/evo-calendar.min.css";
// import "evo-calendar/dist/evo-calendar.min.js";
// import "evo-calendar/dist/evo-calendar.js";
// import "evo-calendar/dist/evo-calendar.min.js.map";

$(document).ready(function () {
  $("#calendar").evoCalendar({
    settingName: "Calendar",
    theme: "Midnight Blue",
    format: "yyyy-mm-dd",
    titleFormat: "MM yyyy",
    eventHeaderFormat: "MM d, yyyy",
    firstDayOfWeek: 1,
    todayHighlight: true,
    sidebarToggler: true,
    sidebarDisplayDefault: true,
    eventDisplayDefault: true,
    eventListToggler: true,
    calendarEvents: [
      {
        id: "1",
        name: "Event Name 1",
        date: "2022-01-01",
        type: "event",
        everyYear: true,
      },
      {
        id: "2",
        name: "Event Name 2",
        date: "2022-01-02",
        type: "event",
        everyYear: true,
      },
      {
        id: "3",
        name: "Event Name 3",
        date: "2022-01-03",
        type: "event",
        everyYear: true,
      },
      {
        id: "4",
        name: "Event Name 4",
        date: "2022-01-04",
        type: "event",
        everyYear: true,
      },
      {
        id: "5",
        name: "Event Name 5",
        date: "2022-01-05",
        type: "event",
        everyYear: true,
      },
      {
        id: "6",
        name: "Event Name 6",
        date: "2022-01-06",
        type: "event",
        everyYear: true,
      },
    ],
  });
});
