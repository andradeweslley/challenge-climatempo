import React from "react";

import axios from "axios";

const loadWeather = (inputValue: string, callback: any) => {
    axios.get(`http://localhost:8000/api/v1/weather`)
        .then((response) => {
            callback(response.data.map((locale: any) => {
                        return { value: locale.id, label: locale.name }
                    }));
        })
}

const Weather = () => {
    return (
        <div className="row justify-content-center mt-5">
            <div className="col-md-8">
                <div className="card text-center">
                    <div className="card-header"><h2>React Component in Laravel.</h2></div>
                    <div className="card-body">I'm tiny React component in Laravel app!</div>
                </div>
            </div>
        </div>
    );
}

export default Weather;