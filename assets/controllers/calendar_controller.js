import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  connect() {
    this.element.textContent =
      "Hello Stimulus! Edit me in assets/controllers/hello_controller.js";
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
  }
}
