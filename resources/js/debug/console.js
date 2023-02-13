window.addEventListener("keydown", (e) => {
    if (e.key == "Enter" && e.ctrlKey) {
        console.table(window.__lmf.supporter.data);
    }
});
