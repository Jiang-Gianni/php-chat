<?php
function CommonImport() {
    ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">

<script src="https://unpkg.com/htmx.org@1.9.10"
    integrity="sha384-D1Kt99CQMDuVetoL1lrYwg5t+9QdHe7NLX/SoJYkXDFfX37iInKRy5xLSi8nO7UC"
    crossorigin="anonymous"></script>

<script src="https://unpkg.com/htmx.org/dist/ext/ws.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@unocss/runtime"></script>

<style>
    [un-cloak] {
        display: none;
    }
</style>

<script>
    htmx.logAll()
</script>

<script>
    const isOpenClass = "modal-is-open", openingClass = "modal-is-opening", closingClass = "modal-is-closing", animationDuration = 400; let visibleModal = null; const toggleModal = e => { e.preventDefault(); e = document.getElementById(e.currentTarget.getAttribute("data-target")); (void 0 !== e && null != e && isModalOpen(e) ? closeModal : openModal)(e) }, isModalOpen = e => !(!e.hasAttribute("open") || "false" == e.getAttribute("open")), openModal = e => { isScrollbarVisible() && document.documentElement.style.setProperty("--scrollbar-width", getScrollbarWidth() + "px"), document.documentElement.classList.add(isOpenClass, openingClass), setTimeout(() => { visibleModal = e, document.documentElement.classList.remove(openingClass) }, animationDuration), e.setAttribute("open", !0) }, closeModal = e => { visibleModal = null, document.documentElement.classList.add(closingClass), setTimeout(() => { document.documentElement.classList.remove(closingClass, isOpenClass), document.documentElement.style.removeProperty("--scrollbar-width"), e.removeAttribute("open") }, animationDuration) }, getScrollbarWidth = (document.addEventListener("click", e => { null == visibleModal || visibleModal.querySelector("article").contains(e.target) || closeModal(visibleModal) }), document.addEventListener("keydown", e => { "Escape" === e.key && null != visibleModal && closeModal(visibleModal) }), () => { var e = document.createElement("div"), t = (e.style.visibility = "hidden", e.style.overflow = "scroll", e.style.msOverflowStyle = "scrollbar", document.body.appendChild(e), document.createElement("div")), t = (e.appendChild(t), e.offsetWidth - t.offsetWidth); return e.parentNode.removeChild(e), t }), isScrollbarVisible = () => document.body.scrollHeight > screen.height;
</script>

    <?php
}
?>