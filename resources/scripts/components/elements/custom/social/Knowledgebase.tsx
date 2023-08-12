import React, { useEffect, useState } from 'react';
import * as Icon from 'react-feather';
import getTheme from '@/api/getThemeData';

export default () => {
    const [themeData, setThemeData] = useState();
    
    useEffect(() => {
        async function getThemeData() {
            const data = await getTheme();
            setThemeData(data.knowledgebase);
        }
        getThemeData();
    }, []);

    return (
        <>
        {themeData !== 'none' &&
            <a href={themeData} css='display:var(--knowledgebase) !important;'>
                <div className='icon'>
                    <Icon.BookOpen size={20}/>
                </div>
                <span>Knowledgebase</span>
            </a>
        }
        </>
    );
};
