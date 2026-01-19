document.addEventListener('DOMContentLoaded', function () {
    const description = document.getElementById('description');
    const updateButton = document.getElementById('updateButton');
    const charCount = document.getElementById('charCount');

    function updateDescription() {
        const formData = new FormData();
        formData.append('description', description.value);

        axios.post('/update-description', formData)
            .then(response => {
                if (response.data.success) {
                    console.log('Description updated successfully!');
                    // Refresh halaman setelah upload sukses
                    location.reload();
                } else {
                    console.log('Description update failed!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Function to update character count
    function updateCharCount() {
        charCount.textContent = `${description.value.length} characters`;
    }

    // Update character count on page load
    updateCharCount();

    // Update character count on input
    description.addEventListener('input', updateCharCount);

    // Trigger updateDescription function when the button is clicked
    updateButton.addEventListener('click', updateDescription);

});
