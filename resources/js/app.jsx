// Generic Solid.js mounting bridge.
//
// Blade components render placeholder elements carrying `solid-component`
// (registry name) and `solid-props` (JSON) attributes. Register components
// in the JSX map below; they are lazily mounted when scrolled into view.

import { render } from "solid-js/web";

const JSX = {
    // "counter": lazy(() => import("./components/Counter").then(m => m.Counter)),
};

const MOUNT = "DOMContentLoaded";
const SOLID_COMP_ATTR = "solid-component";
const SOLID_PROPS_ATTR = "solid-props";
const SOLID_ATTR_SELECTOR = `[${SOLID_COMP_ATTR}]`;

document.addEventListener(MOUNT, mountJsx);

function mountJsx() {
    const observer = new IntersectionObserver((entries) => {
        for (const entry of entries) {
            if (!entry.isIntersecting) {
                continue;
            }

            mount(entry.target);
            observer.unobserve(entry.target);
        }
    }, {});

    const elements = document.body.querySelectorAll(SOLID_ATTR_SELECTOR);

    for (const el of elements) {
        observer.observe(el);
    }
}

function mount(el) {
    const name = el.getAttribute(SOLID_COMP_ATTR);
    const Element = JSX[name];

    if (!Element) {
        console.warn(`JSX element "${name}" not found`, el);
        return;
    }

    let data = el.getAttribute(SOLID_PROPS_ATTR);
    try {
        data = data ? JSON.parse(data) : {};
    } catch (error) {
        console.error(`Error parsing data for jsx element "${name}"`, error);
        data = {};
    }

    render(() => <Element {...data} />, el);
}
