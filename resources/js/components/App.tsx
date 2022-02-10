import React, { useEffect, useState } from 'react';

import '../assets/css/clima-tempo.css';

import Search from './Search';

const App = () => {
    const [locale, setLocale] = useState();

    const changeLocale = (locale: any) => {
        setLocale(locale)
    }

    return (
        <div className="container-fluid p-0">
            <div className="row logo p-4 m-0 text-center">
                <div className="col-md-12">
                    <img src={require('../assets/images/logo-white.png').default} alt="logo" />
                </div>
            </div>
            <div className="row search-locales p-4 m-0">
                <div className="col-md-12">
                    <Search />
                </div>
            </div>
            <div className="row justify-content-center mt-5">
                <div className="col-md-8">
                    <div className="card text-center">
                        <div className="card-header"><h2>React Component in Laravel.</h2></div>
                        <div className="card-body">I'm tiny React component in Laravel app!</div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default App;