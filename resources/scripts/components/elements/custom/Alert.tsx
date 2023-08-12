import React, { useEffect, useState } from 'react';
import * as Icon from 'react-feather';
import styled from 'styled-components/macro';
import getTheme from '@/api/getThemeData';
import AlertDescription from '@/components/elements/custom/AlertDescription';
import tw from 'twin.macro';

const Alert = styled.div`
    ${tw`flex items-center shadow px-4 py-3 mt-4 text-white`}
    border-radius:var(--borderradius);
`;

export default () => {
    const [themeData, setThemeData] = useState();
    
    useEffect(() => {
        async function getThemeData() {
            const data = await getTheme();
            setThemeData(data.typealert);
        }
        getThemeData();
    }, []);

    return (
        <>
            {themeData == 'info' && 
                <Alert css='background-color: #589AFC;'>
                    <Icon.Info css={tw`mr-2`} /> <AlertDescription/>
                </Alert>
            }
            {themeData == 'warning' && 
                <Alert css='background-color: #FBA101;'>
                    <Icon.AlertCircle css={tw`mr-2`}/> <AlertDescription/>
                </Alert>
            }
            {themeData == 'error' && 
                <Alert css='background-color: #DF5438;'>
                    <Icon.XCircle css={tw`mr-2`} /> <AlertDescription/>
                </Alert>
            }
            {themeData == 'success' && 
                <Alert css='background-color: #45AF45;'>
                    <Icon.CheckCircle css={tw`mr-2`} /> <AlertDescription/>
                </Alert>
            }
        </>
    );
};
