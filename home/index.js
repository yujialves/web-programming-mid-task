new Vue({
  el: "#app",
  data: {
    showAddModal: false,
    showEditModal: false,
    id: null,
    begin: "",
    end: "",
    place: "",
    content: "",
    inner_schedules: [],
  },
  methods: {
    cancel() {
      this.showAddModal = false;
      this.showEditModal = false;
      this.id = null;
      this.begin = "";
      this.end = "";
      this.place = "";
      this.content = "";
    },
    editSchedule(schedule) {
      this.id = schedule.id;
      this.begin = schedule.begin.replace(" ", "T");
      this.end = schedule.end.replace(" ", "T");
      this.place = schedule.place;
      this.content = schedule.content;
      this.showEditModal = true;
    },
    register: async function () {
      if (
        this.begin.trim() === "" ||
        this.end.trim() === "" ||
        this.place.trim() === "" ||
        this.content.trim() === ""
      ) {
        return;
      }
      const formData = new FormData();
      formData.append("begin", this.begin);
      formData.append("end", this.end);
      formData.append("place", this.place);
      formData.append("content", this.content);
      const response = await fetch("../api/register.php", {
        method: "POST",
        body: formData,
      });
      const data = await response.json();
      this.inner_schedules = data;
      this.id = null;
      this.begin = "";
      this.end = "";
      this.place = "";
      this.content = "";
      this.showAddModal = false;
    },
    update: async function (schedule) {
      if (
        this.id === null ||
        this.begin.trim() === "" ||
        this.end.trim() === "" ||
        this.place.trim() === "" ||
        this.content.trim() === ""
      ) {
        return;
      }
      const formData = new FormData();
      formData.append("id", this.id);
      formData.append("begin", this.begin);
      formData.append("end", this.end);
      formData.append("place", this.place);
      formData.append("content", this.content);
      const response = await fetch("../api/update.php", {
        method: "POST",
        body: formData,
      });
      const data = await response.json();
      this.inner_schedules = data;
      this.id = null;
      this.begin = "";
      this.end = "";
      this.place = "";
      this.content = "";
      this.showEditModal = false;
    },
    remove: async function (id) {
      if (id.trim() == "") {
        return;
      }
      const formData = new FormData();
      formData.append("id", id);
      const response = await fetch("../api/remove.php", {
        method: "POST",
        body: formData,
      });
      const data = await response.json();
      this.inner_schedules = data;
    },
  },
  computed: {
    schedules() {
      return this.inner_schedules.map((schedule) => {
        return {
          ...schedule,
          removeBtnId: `remove-btn-${schedule.id}`,
          updateBtnId: `update-btn-${schedule.id}`,
        };
      });
    },
  },
  created: async function () {
    const response = await fetch("../api/fetch.php");
    const data = await response.json();
    this.inner_schedules = data;
  },
});
