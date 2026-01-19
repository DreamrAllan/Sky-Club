import { DataTable } from "simple-datatables";
document.addEventListener("DOMContentLoaded", function() {
    let dataTable = new DataTable("#search-table", {
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
                    `
                        <div class='w-full grid grid-cols-2 lg:flex lg:justify-end gap-x-4 md:gap-x-2'>
                            <button data-modal-target="createVoucherModal" data-modal-toggle="createVoucherModal" class="flex items-center justify-center px-6 py-2 bg-red-600 text-white font-medium text-md  rounded-lg hover:bg-red-700 focus:bg-red-700 focus:outline-none focus:ring-0 active:bg-red-800 ">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                Tambah Voucher
                            </button>
                            <label>
                                <select class='${options.classes.selector} w-full focus:ring-red-600 focus:border-red-600'></select>
                            </label>
                    </div>` :
                    ""
                }
                ${
                    options.searchable ?
                    `<div class='${options.classes.search } w-full'>
                        <input class='${options.classes.input} focus:ring-red-600 w-full' placeholder='${options.labels.placeholder}' type='search' title='${options.labels.searchTitle}'${dom.id ? ` aria-controls="${dom.id}"` : ""}>
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
