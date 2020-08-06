const app = new Vue({
  el: "#app",
  data() {
    return {
      nameUser: "",
      namePass: "",
      isError: false,
      msgError: "",
    };
  },
  methods: {
    async sendData() {
      if (!this.nameUser || !this.namePass) {
        this.showError("Debes completar los campos");
        return;
      }
      this.sendRequestLogin("/api/login/");
    },
    showError(msg) {
      this.isError = true;
      this.msgError = msg;
      setInterval(() => {
        this.isError = false;
        this.msgError = "";
      }, 5000);
    },
    sendRequestLogin(path) {
      $.ajax({
        type: "POST",
        url: path,
        data: {
          nameUser: this.nameUser,
          namePass: this.namePass,
        },
        dataType: "json",
        beforeSend: () => {
          $("#formLogin button").text("Verificando...");
        },
        success: function (res) {
          $("#formLogin button").text("Ingresar");
          if (res.status >= 400) {
            $(".card-footer .alert").html(
              `<strong><i class="fas fa-times-circle m-0 mr-2"></i>${res.msg}</strong>`
            );
            $(".card-footer ").addClass("d-block");
            setInterval(() => {
              $(".card-footer ").removeClass("d-block");
            }, 5000);
            return;
          }
          $(".card-footer .alert")
            .html(
              `<strong><i class="fas fa-check-circle mr-2"></i>${res.msg}</strong>`
            )
            .addClass("alert-success")
            .removeClass("alert-danger");
          $(".card-footer").addClass("d-block");

          window.location = res.data.redirect;
        },
        done: function (err) {
          console.log(err);
        },
      });
    },
  },
});
