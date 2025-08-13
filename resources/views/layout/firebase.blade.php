{{-- 


    <script type="module">
    // Import the necessary Firebase components
    import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js';
        import { getAuth, signInWithPhoneNumber, RecaptchaVerifier } from 'https://www.gstatic.com/firebasejs/9.0.0/firebase-auth.js';

        // Firebase configuration from your Firebase Console
        const firebaseConfig = {
            apiKey: "AIzaSyBU8ZYxD8eo1m3uRCsD-Bx7S-nnIRJiDWM",
            authDomain: "finder-app-be8d5.firebaseapp.com",
            projectId: "finder-app-be8d5",
            storageBucket: "finder-app-be8d5.appspot.com",
            messagingSenderId: "1083573166983",
            appId: "1:1083573166983:web:e7f4a7e844c8ff8d68e922"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
</script>
 --}}



{{-- script to get location  --}}

@if(!Request::is('personal-info'))
<script>
    function loadGoogleMaps(callback) {
        const script = document.createElement('script');
        script.src =
            "https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initDistance";
        script.async = true;
        script.defer = true;
        window.initDistance = callback;
        document.head.appendChild(script);

    }
</script>

<script>
    function initDistance() {
        if (!navigator.geolocation) {
            document.querySelectorAll('.distance').forEach(el => el.style.display = 'none');
            return;
        }

        navigator.geolocation.getCurrentPosition(function(pos) {
            const userLat = pos.coords.latitude;
            const userLng = pos.coords.longitude;

            const service = new google.maps.DistanceMatrixService();

            const carElements = Array.from(document.querySelectorAll('.car'));

            const validCars = carElements.filter(el => {
                const lat = el.dataset.latitude;
                const lng = el.dataset.longitude;
                if (!lat || !lng) {
                    const distanceEl = el.querySelector('.distance');
                    if (distanceEl) distanceEl.style.display = 'none';
                    return false;
                }
                return true;
            });

            const destinations = validCars.map(el =>
                new google.maps.LatLng(parseFloat(el.dataset.latitude), parseFloat(el.dataset.longitude))
            );

            service.getDistanceMatrix({
                origins: [new google.maps.LatLng(userLat, userLng)],
                destinations: destinations,
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC
            }, function(response, status) {
                if (status !== google.maps.DistanceMatrixStatus.OK) return;

                const elements = response.rows[0].elements;
                validCars.forEach((el, index) => {
                    const distanceText = elements[index].status === 'OK' ? elements[index]
                        .distance.text : null;
                    const distanceEl = el.querySelector('.distance');
                    if (distanceEl && distanceText) {
                        distanceEl.textContent = `${distanceText} away`;
                    } else if (distanceEl) {
                        distanceEl.style.display = 'none';
                    }
                });
            });

        }, function() {
            document.querySelectorAll('.distance').forEach(el => el.style.display = 'none');
        });
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        loadGoogleMaps(initDistance);
    });
</script>
@endif


