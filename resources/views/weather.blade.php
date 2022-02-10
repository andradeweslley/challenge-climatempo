<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/tomik23/autocomplete@1.7.3/dist/css/autocomplete.min.css"/>

        <link href="{{ asset('css/clima-tempo.css') }}" rel="stylesheet">

        <title>Climatempo</title>
    </head>
    <body>
        <div class="container-fluid p-0">
            <div class="row logo p-4 m-0 text-center">
                <div class="col-md-12">
                    <img src='{{ asset('images/logo-white.png') }}' alt="logo" />
                </div>
            </div>
            <div class="row search-locales p-4 m-0">
                <div class="col-md-12">
                    <div class="auto-search-wrapper">
                        <input type="text" id="basic" placeholder="Busque por uma cidade...">
                        <input type="hidden" id="locale-id">
                    </div>
                </div>
            </div>
            <div class="row mt-2 p-4">
                <div class="col-md-12">
                    <div class="row justify-content-center weather"></div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/tomik23/autocomplete@1.7.3/dist/js/autocomplete.min.js"></script>

        <script>
            const getWeather = (localeId) => {
                fetch(`/api/v1/weather?locale=${localeId}`)
                    .then((response) => response.json())
                    .then((response) => {
                        console.log(response);

                        const weatherElement = document.querySelector('.weather');

                        response.weather.map((weather) => {
                            weatherElement.innerHTML += `
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header pb-0">
                                            <small>${weather.date}</small>
                                            <p>${weather.text}</p>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <div class="row justify-content-center">
                                                        <div class="offset-md-1 col-md-2 col-4">
                                                            <img src='{{ asset('images/icons/upload.png') }}' alt="logo" />
                                                        </div>
                                                        <div class="col-6">${weather.temperature.max}˚</div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="row justify-content-center">
                                                        <div class="offset-md-1 col-md-2 col-4">
                                                            <img src='{{ asset('images/icons/download.png') }}' alt="logo" />
                                                        </div>
                                                        <div class="col-6">${weather.temperature.min}˚</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="row justify-content-center">
                                                        <div class="offset-md-1 col-md-2 col-4">
                                                            <img src='{{ asset('images/icons/raindrop-close-up.png') }}' alt="logo" />
                                                        </div>
                                                        <div class="col-6">${weather.rain.precipitation} mm</div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="row justify-content-center">
                                                        <div class="offset-md-1 col-md-2 col-4">
                                                            <img src='{{ asset('images/icons/protection-symbol-of-opened-umbrella-silhouette-under-raindrops.png') }}' alt="logo" />
                                                        </div>
                                                        <div class="col-6">${weather.rain.probability} %</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        })
                    })
            }

            new Autocomplete("basic", {
                onSearch: ({ currentValue }) => {
                    const api = `/api/v1/locales?q=${encodeURI(
                        currentValue
                    )}`;

                    return new Promise((resolve) => {
                        fetch(api)
                            .then((response) => response.json())
                            .then((data) => {
                                resolve(data);
                            })
                            .catch((error) => {
                                console.error(error);
                            });
                        });
                    },

                onResults: ({ matches }) =>
                    matches.map((el) => `<li>${el.name}</li>`).join(""),
                
                onSubmit: ({ index, element, object, results }) => (
                    getWeather(object.id)),
            });
        </script>
    </body>
</html>