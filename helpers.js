//a function 
const toggleSelected = (e) => {
    if (e.type === 'keydown') {
        if (!(e.key == "Space" || e.keyCode == 32)) {
            return false
        }
    }
    if (e.target.dataset["selected"] === "false") {
        const precisionSelectors = document.querySelectorAll(".precision-option")
        precisionSelectors.forEach(el => {
            el.classList.remove("selected");
            el.dataset.selected = "false";

        })
        e.target.classList.add("selected");
        e.target.dataset.selected = "true";
    }
}