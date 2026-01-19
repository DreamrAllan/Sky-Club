import { DataTable } from "simple-datatables";
document.addEventListener("DOMContentLoaded", function() {
    let dataTable = new DataTable("#table-booking", {
        searchable: true,
        fixedHeight: true,
        paging: true,
        perPage: 10,
        perPageSelect: [5, 10, 25, 50, 100],
        sortable: true,
        classes: {
            search: "w-full sm:w-1/2",
            dropdown: "rounded-lg",
            selector: "w-full bg-white border border-gray-300 rounded-lg",
        },
        template: (options, dom) => `
            <div class='${options.classes.top} px-6 '>
            ${
                options.paging && options.perPageSelect ?
                    `<div class='${options.classes.dropdown}'>
                        <label>
                            <select class='${options.classes.selector}'></select>
                        </label>
                    </div>` :
                    ""
            }
                ${
                options.searchable ?
                    `<div class='${options.classes.search}'>
                        <input class='${options.classes.input}' placeholder='${options.labels.placeholder}' type='search' title='${options.labels.searchTitle}'${dom.id ? ` aria-controls="${dom.id}"` : ""}>
                    </div>` :
                    ""
            }
            </div>
            <div class='${options.classes.container}'${options.scrollY.length ? ` style='height: ${options.scrollY}; overflow-Y: auto;'` : ""}></div>
            <div class='${options.classes.bottom} px-6 mb-6'>
                ${
                    options.paging ?
                    `<div class='${options.classes.info}'></div>` :
                    ""
                }
                <nav class='${options.classes.pagination}'></nav>
            </div>
        `
    });
});
