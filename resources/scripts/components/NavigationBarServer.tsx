import * as React from 'react';
import * as Icon from 'react-feather';
import { Link, NavLink } from 'react-router-dom';
import { useStoreState } from 'easy-peasy';
import { ApplicationStore } from '@/state';
import tw, { theme } from 'twin.macro';
import styled from 'styled-components/macro';
import Can from '@/components/elements/Can';
import http from '@/api/http';
import SpinnerOverlay from '@/components/elements/SpinnerOverlay';
import DarkModeToggler from '@/components/elements/custom/DarkModeToggler';
import SocialButtons from '@/components/elements/custom/SocialButtons';
import NavigationBar from '@/components/elements/custom/NavigationBar';
import CollapseBtn from '@/components/elements/custom/CollapseBtn';
import { ServerContext } from '@/state/server';
import { useState, useEffect } from 'react';
import getTheme from '@/api/getThemeData';
import { Nav } from '@/routers/SideBarElements';
import * as Lang from '@/lang';

export default () => {

    const id = ServerContext.useStoreState(state => state.server.data?.id);

    const name = useStoreState((state: ApplicationStore) => state.settings.data!.name);
    const rootAdmin = useStoreState((state: ApplicationStore) => state.user.data!.rootAdmin);
    const [ isLoggingOut, setIsLoggingOut ] = useState(false);

    const onTriggerLogout = () => {
        setIsLoggingOut(true);
        http.post('/auth/logout').finally(() => {
            // @ts-ignore
            window.location = '/';
        });
    };

    const [themeData, setThemeData] = useState();
    
    useEffect(() => {
        async function getThemeData() {
            const data = await getTheme();
            setThemeData(data.logo);
        }
        getThemeData();
    }, []);

    return (
        <NavigationBar>
            <SpinnerOverlay visible={isLoggingOut} />
            <div css={tw`w-full`}>
                <div id={'logo'}>
                    <Link to={'/'}>
                        <img src={themeData} />
                        <span>{name}</span>
                    </Link>
                    <div className='collapseBtn'>
                        <CollapseBtn/>
                    </div>
                </div>
                    <NavLink to={'/account'} exact>
                        <div className='icon'>
                            <Icon.User size={20}/>
                        </div>
                        <span>{Lang.Account}</span>
                    </NavLink>
                    <NavLink to={'/'} exact>
                        <div className='icon'>
                            <Icon.Layers size={20}/>
                        </div>
                        <span>{Lang.Servers}</span>
                    </NavLink>
                    <span className='subTitle'>SERVER CONTROLS</span>
                    <Nav />
                    <div className='media'>
                        <SocialButtons/>
                    </div>
                    <div className='logOut'>
                        <DarkModeToggler/>
                        {rootAdmin &&
                        <a href={'/admin'} rel={'noreferrer'}>
                            <div className='icon'>
                                <Icon.Settings size={20}/>
                            </div>
                        </a>
                        }
                        <button onClick={onTriggerLogout}>
                            <div className='icon'>
                                <Icon.LogOut size={20}/>
                            </div>
                        </button>
                    </div>
            </div>
        </NavigationBar>
    );
};
