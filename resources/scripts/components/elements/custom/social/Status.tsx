import React, { useEffect, useState } from 'react';
import * as Icon from 'react-feather';
import getTheme from '@/api/getThemeData';

export default () => {
    const [themeData, setThemeData] = useState();
    
    useEffect(() => {
        async function getThemeData() {
            const data = await getTheme();
            setThemeData(data.status);
        }
        getThemeData();
    }, []);

    return (
        <>
        {themeData !== 'none' &&
            <a href={themeData} css='display:var(--status) !important;'>
                <div className='icon'>
                    <Icon.Wifi size={20}/>
                </div>
                <span>Status</span>
            </a>
        }
        </>
    );
};
