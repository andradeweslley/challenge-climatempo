import React, { Component } from "react";
import axios from 'axios';

import AsyncSelect from "react-select/async";

interface State {
    readonly inputValue: string
}

const loadOptions = (inputValue: string, callback: any) => {
    axios.get(`http://localhost:8000/api/v1/locales?q=${inputValue}`)
        .then((response) => {
            callback(response.data.map((locale: any) => {
                        return { value: locale.id, label: locale.name }
                    }));
        })
}

export default class Search extends Component<{}, State> {
    state: State = { inputValue: '' };

    handleInputChange = (newValue: string) => {
        const inputValue = newValue;
        this.setState({ inputValue });
        return inputValue;
    };
    
    render() {
        return (
            <div>
                <pre>inputValue: "{this.state.inputValue}"</pre>
                <AsyncSelect
                    cacheOptions
                    loadOptions={loadOptions}
                    defaultOptions={false}
                    onInputChange={this.handleInputChange}
                    loadingMessage={() => {return 'Carregando'}}
                    noOptionsMessage={() => {return 'Nenhuma cidade encontrada'}}
                    placeholder={'Digite uma cidade para busca'}
                />
            </div>
        );
    }
}