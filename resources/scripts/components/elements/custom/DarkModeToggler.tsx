import * as React from 'react';
import * as Icon from 'react-feather';

export default () => {
    if (localStorage.getItem('modes') == 'darkMode'){
        document.body.classList.add('darkmode');
    } else {
        document.body.classList.remove('darkmode');
    }

    const toggleDarkMode = () => {
        if (localStorage.getItem('modes') == 'darkMode'){
            localStorage.setItem('modes', 'null');
            document.body.classList.remove('darkmode');
        } else {
            localStorage.setItem('modes', 'darkMode');
            document.body.classList.add('darkmode');
        }
    }

    return (
        <button onClick={toggleDarkMode}>
            <div className='icon'>
                <Icon.Moon size={20}/>
            </div>
        </button>
    );
};
