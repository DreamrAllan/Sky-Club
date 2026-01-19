import Dropzone from "dropzone";
import "dropzone/dist/dropzone.css";

// Nonaktifkan auto-discover agar Dropzone tidak otomatis menginisialisasi elemen
Dropzone.autoDiscover = false;

// Inisialisasi Dropzone
const dropzoneForm = new Dropzone("#dropzone-form", {
    url: "/payment/uploadImage", // Endpoint backend untuk upload
    method: "post", // Use POST method to match the form method
    autoProcessQueue: false, // Disable auto process
    maxFiles: 1, // Maksimal file yang diizinkan
    maxFilesize: 2, // Maksimal ukuran file dalam MB
    acceptedFiles: ".png,.jpg,.jpeg,.gif,.svg",
    headers: {
        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value, // Kirim CSRF token
    },
    paramName: "photo", // Ensure the field name matches the controller
    dictDefaultMessage: `
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-4 text-red-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
            </svg>
            <p class="mb-2 text-sm text-red-500 dark:text-gray-400">
                <span class="font-semibold">Click to upload</span> or drag and drop
            </p>
            <p class="text-xs text-red-500 dark:text-gray-400">
                SVG, PNG, JPG or GIF (Maximal 2MB)
            </p>
        </div>
    `,
    init: function () {
        this.on("addedfile", function (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                const dropzoneElement = document.querySelector("#dropzone-form");
                dropzoneElement.style.backgroundImage = `url(${event.target.result})`;
                dropzoneElement.style.backgroundSize = "cover";
                dropzoneElement.style.backgroundPosition = "center";
                dropzoneElement.style.backgroundRepeat = "no-repeat";
            };
            reader.readAsDataURL(file);
        });

        const submitButton = document.querySelector("#upload-button");
        const myDropzone = this;

        submitButton.addEventListener("click", function (e) {
            e.preventDefault();
            myDropzone.processQueue(); // Process the file upload
        });

        this.on("sending", function(file, xhr, formData) {
            formData.append("_method", "PUT"); // Append the _method field to spoof PUT
        });

        this.on("success", function (file, response) {
            console.log("File successfully uploaded:", response);
            window.location.href = response.redirect_url; // Redirect to success page
        });

        this.on("error", function (file, errorMessage) {
            console.error("Upload error:", errorMessage);
            if (file.size > this.options.maxFilesize * 1024 * 1024) {
                alert("File terlalu besar. Halaman akan dimuat ulang.");
                window.location.reload(); // Reload the page if the file is too large
            }
        });
    },
});
