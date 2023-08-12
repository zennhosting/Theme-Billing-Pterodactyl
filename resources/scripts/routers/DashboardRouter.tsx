import React, { useEffect, useState } from 'react';
import { NavLink, Route, Switch } from 'react-router-dom';
import NavigationBar from '@/components/NavigationBar';
import DashboardContainer from '@/components/dashboard/DashboardContainer';
import { NotFound } from '@/components/elements/ScreenBlock';
import TransitionRouter from '@/TransitionRouter';
import SubNavigation from '@/components/elements/SubNavigation';
import { useLocation } from 'react-router';
import SearchContainer from '@/components/dashboard/search/SearchContainer';
import Alert from '@/components/elements/custom/Alert';
import styled from 'styled-components/macro';
import Spinner from '@/components/elements/Spinner';
import routes from '@/routers/routes';
import ContentContainer from '@/components/elements/ContentContainer';
import CollapseBtn from '@/components/elements/custom/CollapseBtn';

const ContainerBlock = styled.div`
    display:flex;
    width:100%;

    & > .contentBlock{
        width:100%;
    }
    @media only screen and (max-width:979px){
      &{
          display:block;
      }
      & .collapseBtn{
          display:none;
      }
    }
`;

export default () => {
    const location = useLocation();

    return (
        <ContainerBlock>
            <>
                <NavigationBar />
                <div className='contentBlock'>
                <ContentContainer>
                    <SubNavigation>
                        <div>
                            <div className='collapseBtn'>
                                <CollapseBtn/>
                            </div>
                            <SearchContainer/>
                        </div>
                        {location.pathname.startsWith('/account') && (
                            <>
                                <div css='display:var(--subnavigation) !important;'>
                                    {routes.account
                                        .filter((route) => !!route.name)
                                        .map(({ path, name, exact = false }) => (
                                            <NavLink key={path} to={`/account/${path}`.replace('//', '/')} exact={exact}>
                                                {name}
                                            </NavLink>
                                        ))}
                                    </div>
                                </>
                            )}
                        </SubNavigation>
                        <Alert/>
                </ContentContainer>
                <TransitionRouter>
                    <React.Suspense fallback={<Spinner centered />}>
                        <Switch location={location}>
                            <Route path={'/'} exact>
                                <DashboardContainer />
                            </Route>
                            {routes.account.map(({ path, component: Component }) => (
                                <Route key={path} path={`/account/${path}`.replace('//', '/')} exact>
                                    <Component />
                                </Route>
                            ))}
                            <Route path={'*'}>
                                <NotFound />
                            </Route>
                        </Switch>
                    </React.Suspense>
                </TransitionRouter>
                </div>
            </>
        </ContainerBlock>
    );
};
