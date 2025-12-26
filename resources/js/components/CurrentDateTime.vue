<template>
    <div class="text-lg font-semibold">
        {{ dateTime }} <!-- Displays server date & time -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            dateTime: '' // Stores server time
        }
    },
    mounted() {
        this.fetchTime(); // Fetch time on component load
        this.timer = setInterval(this.fetchTime, 1000); // Update every second
    },
    beforeUnmount() {
        clearInterval(this.timer); // Clear timer when component is destroyed
    },
    methods: {
        fetchTime() {
            fetch('/current-datetime') // Call Laravel route
                .then(response => response.json())
                .then(data => {
                    this.dateTime = data.datetime; // Update time from server
                })
                .catch(error => {
                    console.error('Time fetch error:', error); // Log error
                });
        }
    }
}
</script>
