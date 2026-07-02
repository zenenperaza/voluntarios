"use strict";
$(document).ready(function () {
    // Wizard básico
    $("#basicwizard").bootstrapWizard();

    // Wizard con progress bar + validación
    $("#progressbarwizard").bootstrapWizard({
        onTabShow: function (tab, navigation, index) {
            const total = navigation.find("li").length;
            const current = index + 1;
            const percent = (current / total) * 100;

            $("#progressbarwizard")
                .find(".bar")
                .css({ width: percent + "%" });
        },
        onNext: function (tab, navigation, index) {
            const $form = $($(tab).data("targetForm") || "#formCaso"); // Asegúrate de asignar correctamente

            if (
                $form.length &&
                ($form.addClass("was-validated"), !$form[0].checkValidity())
            ) {
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
        },
    });

    // Botones personalizados
    $("#btnwizard").bootstrapWizard({
        nextSelector: ".button-next",
        previousSelector: ".button-previous",
        firstSelector: ".button-first",
        lastSelector: ".button-last",
    });

    // Wizard con validación
    $("#rootwizard").bootstrapWizard({
        onNext: function (tab, navigation, index) {
            const $form = $($(tab).data("targetForm") || "#formCaso");

            if (
                $form.length &&
                ($form.addClass("was-validated"), !$form[0].checkValidity())
            ) {
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
        },
    });
});
