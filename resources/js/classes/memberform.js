import validate from "validate.js";

class MemberForm {
    constructor() {
        if (!window.__lmf) {
            window.__lmf = this;
        }
        this._uuid = document.querySelector(".los-memberform-base").dataset.supporterUuid;
        this._h = new Set();
        this.history = Array.from(this._h);
        this.supporter = {};
        document.addEventListener('DOMContentLoaded', () => {
            this.initButtons();
            this.initForms();
            this.initChoices();
            this.initHistory();
            this.initKeydown();
            if (document.querySelector(".los-memberform-step-container.active form")) {
                this.validateForm(document.querySelector(".los-memberform-step-container.active form"));
            }
            this.addHistory(document.querySelector(".los-memberform-step-container.active").dataset.stepKey);
        });

        this.s_type_init = this.s_type_init.bind(this);
        this.s_type_add = this.s_type_add.bind(this);
        this.addHistory = this.addHistory.bind(this);
    }

    async addHistory(h) {
        this._h.add(h);
        this.history = Array.from(this._h);
        let r = await fetch("/s/update", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "uuid": window.__lmf._uuid,
                "history": JSON.stringify(this.history),
            })
        });
        r = await r.json();
        console.log(r);
    }

    async removeHistory(h) {
        this._h.delete(h);
        this.history = Array.from(this._h);
        let r = await fetch("/s/update", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "uuid": window.__lmf._uuid,
                "history": JSON.stringify(this.history),
            })
        });
        r = await r.json();
        console.log(r);
    }

    initButtons() {
        document.querySelectorAll("[type='los-memberform']").forEach((button) => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                let actions = button.getAttribute("action").split("|");
                let i = 0;
                this.doAction(actions, actions[0], i);
            });
        });
    }

    initForms() {
        document.querySelectorAll(".los-memberform-step-inner form").forEach((form) => {
            form.addEventListener("input", () => {
                this.validateForm(form);
            });

            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                let submission = await this.submitForm(form);
                if (submission.status == "success") {
                    this.supporter = submission.supporter;
                    this.goto(submission.next);
                }
            });
        });
    }

    initChoices() {
        document.querySelectorAll(".los-input-choices-group").forEach((group) => {
            group.querySelector("label").addEventListener("keydown", (e) => {
                if (e.key == "Enter") {
                    e.preventDefault();
                    group.querySelector("label").click();
                }
            });
        });
    }

    initHistory() {
        let history = document.querySelector(".los-memberform-base").dataset.supporterHistory;
        if (history) {
            history = JSON.parse(history);
            this._h = new Set(history);
            this.history = Array.from(this._h);
        }
    }

    validateForm(form) {
        if (!form.dataset.validation) {
            form.querySelector(".los-input-submit-wrapper").style.maxHeight = form.querySelector(".los-input-submit-wrapper").scrollHeight + "px";
            return;
        }
        let errors = validate(form, JSON.parse(form.dataset.validation));
        if (!errors) {
            form.querySelector(".los-input-submit-wrapper").style.maxHeight = form.querySelector(".los-input-submit-wrapper").scrollHeight + "px";
        } else {
            form.querySelector(".los-input-submit-wrapper").style.maxHeight = "0px";
        }
    }

    async submitForm(form) {
        let formData = new FormData(form);
        formData.append("uuid", window.__lmf._uuid);
        formData.append("next", form.querySelector("button[type='submit']").dataset.next);
        formData.append("history", JSON.stringify(this.history));
        let response = await fetch(form.action, {
            method: "POST",
            body: formData
        });
        response = await response.json();
        console.log(response);
        return response;
    }

    async doAction(actions, action, i) {
        let key = action.substring(0, action.indexOf(":"));
        var result = {};
        switch (key) {
            case "goto":
                let step = action.substring(action.indexOf(":") + 1);
                this.goto(step);
                result.status = "success";
                result.supporter = this.supporter;
                break;
            case "func":
                let func = action.substring(action.indexOf(":") + 1, action.indexOf("("));
                let params = action.substring(action.indexOf("(") + 1, action.indexOf(")"));
                result = await this[func].apply(null, params.split(", "));
                break;
            default:
                console.log("default");
        }
        i++;
        this.supporter = result.supporter;
        if (i < actions.length && result.status == "success") {
            this.doAction(actions, actions[i], i);
        } else if (result.status == "error") {
            console.log(result.message);
        }
    }

    goto(step) {
        let currentStep = document.querySelector(".los-memberform-step-container.active");
        let nextStep;
        if (step == "BACK") {
            step = this.history[this.history.length - 2];
            this.removeHistory(currentStep.dataset.stepKey);
            nextStep = document.querySelector(".los-memberform-step-container[data-step-key='" + step + "']");
        } else {
            this.addHistory(step);
            nextStep = document.querySelector(".los-memberform-step-container[data-step-key='" + step + "']");
        }
        if (nextStep.classList.contains("future")) {
            currentStep.classList.add("past");
            currentStep.classList.remove("active");
            nextStep.classList.remove("future");
            nextStep.classList.add("active");
        } else {
            currentStep.classList.remove("active");
            currentStep.classList.add("future");
            nextStep.classList.remove("past");
            nextStep.classList.add("active");
        }


        if (nextStep.querySelector("form")) {
            this.validateForm(nextStep.querySelector("form"));
        }

        if (nextStep.hasAttribute("data-form-finished")) {
            this.destroySession();
        }
    }

    async s_type_init(type) {
        let response = await fetch("/s/update", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "uuid": window.__lmf._uuid,
                "history": JSON.stringify(this.history),
                "type": type
            })
        });
        let data = await response.json();
        console.log(data);
        return data;
    }

    async s_type_add(type) {
        let response = await fetch("/s/update", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "uuid": window.__lmf._uuid,
                "history": JSON.stringify(this.history),
                "type": this.supporter.type + "," + type
            })
        });
        let data = await response.json();
        return data;
    }

    async destroySession() {
        let response = await fetch("/s/destroy", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "uuid": window.__lmf._uuid
            })
        });
        let data = await response.json();
        return data;
    }

    initKeydown() {
        window.addEventListener("keydown", (e) => {
            if (document.querySelector(".los-memberform-step-container.active form [data-letter='" + e.key + "']")) {
                document.querySelector(".los-memberform-step-container.active form [data-letter='" + e.key + "']").click();
            }

            // if (document.querySelector(".los-memberform-step-container.active form") && e.key == "Enter") {
            //     console.log("enter");
            //     document.querySelector(".los-memberform-step-container.active form .los-input-submit button").click();
            // }
        });
    }
}

let lmf = new MemberForm();
