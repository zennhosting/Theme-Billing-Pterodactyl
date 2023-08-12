import React from 'react';
import { ServerContext } from '@/state/server';
import routes from '@/routers/routes';
import Can from '@/components/elements/Can';
import { NavLink, useRouteMatch } from 'react-router-dom';

interface Props {
  route: any;
}

const NavItem = ({ route }: Props) => {
  const match = useRouteMatch<{ id: string }>();

  const nestId = ServerContext.useStoreState((state) => state.server.data?.nestId);
  const eggId = ServerContext.useStoreState((state) => state.server.data?.eggId);

  const to = (value: string, url = false) => {
    return `${(url ? match.url : match.path).replace(/\/*$/, '')}/${value.replace(/^\/+/, '')}`;
  };

  return (
    ((route.nestIds && route.nestIds.includes(nestId ?? 0)) ||
      (route.eggIds && route.eggIds.includes(eggId ?? 0)) ||
      (route.nestId && route.nestId === nestId) ||
      (route.eggId && route.eggId === eggId) ||
      (!route.eggIds && !route.nestIds && !route.nestId && !route.eggId)) && (
      <NavLink to={to(route.path, true)} exact={route.exact}>
        <div className='icon'>
          <route.icon size={20} />{' '}
        </div>
        <span>{route.name}</span>
      </NavLink>
    )
  );
};

export const Nav = () => {
  return (
    <>
      {routes.server
        .filter((route) => !!route.name)
        .map((route) =>
          route.permission ? (
            <Can key={route.path} action={route.permission} matchAny>
              <NavItem route={route} />
            </Can>
          ) : (
            <React.Fragment key={route.path}>
              <NavItem route={route} />
            </React.Fragment>
          )
        )}
    </>
  );
};

