import React, { useEffect, useState } from 'react';
import * as Icon from 'react-feather';
import getTheme from '@/api/getThemeData';

export default () => {
    const [themeData, setThemeData] = useState();
    
    useEffect(() => {
        async function getThemeData() {
            const data = await getTheme();
            setThemeData(data.website);
        }
        getThemeData();
    }, []);

    return (
        <>
        {themeData !== 'none' &&
            <a href={themeData} css='display:var(--website) !important;'>
                <div className='icon'>
                    <Icon.Link size={20}/>
                </div>
                <span>Website</span>
            </a>
        }
        </>
    );
};
