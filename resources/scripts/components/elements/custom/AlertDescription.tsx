import React, { useEffect, useState } from 'react';
import getTheme from '@/api/getThemeData';
export default () => {
    const [themeData, setThemeData] = useState();
    
    useEffect(() => {
        async function getThemeData() {
            const data = await getTheme();
            setThemeData(data.alertdescription);
        }
        getThemeData();
    }, []);

    return (
        <>
            {themeData}
        </>
    );
};
