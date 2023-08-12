import * as React from 'react';
import * as Icon from 'react-feather';
import styled from 'styled-components/macro';

const HideShowIcon = styled.div`
    & > *{
        transition:transform .3s;
    }
    .collapse & > * {
        transform:rotate(180deg);
    }
`

export default () => {
    if (localStorage.getItem('collapse') == 'true'){
        document.body.classList.add('collapse');
    } else {
        document.body.classList.remove('collapse');
    }

    const collapseBtn = () => {
        if (localStorage.getItem('collapse') == 'true'){
            localStorage.setItem('collapse', 'null');
            document.body.classList.remove('collapse');
        } else {
            localStorage.setItem('collapse', 'true');
            document.body.classList.add('collapse');
        }
    }

    return (
        <button onClick={collapseBtn}>
            <div className='icon'>
                <HideShowIcon>
                    <Icon.ArrowLeft size={20}/>
                </HideShowIcon>
            </div>
        </button>
    );
};
