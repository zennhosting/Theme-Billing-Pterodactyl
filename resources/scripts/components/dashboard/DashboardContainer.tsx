import React, { useEffect, useState } from 'react';
import { Server } from '@/api/server/getServer';
import getServers from '@/api/getServers';
import ServerRow from '@/components/dashboard/ServerRow';
import ServerCard from '@/components/dashboard/ServerCard';
import Spinner from '@/components/elements/Spinner';
import PageContentBlock from '@/components/elements/PageContentBlock';
import useFlash from '@/plugins/useFlash';
import { useStoreState } from 'easy-peasy';
import { usePersistedState } from '@/plugins/usePersistedState';
import Switch from '@/components/elements/Switch';
import tw from 'twin.macro';
import useSWR from 'swr';
import { PaginatedResult } from '@/api/http';
import Pagination from '@/components/elements/Pagination';
import { useLocation } from 'react-router-dom';
import styled from 'styled-components/macro';
import getTheme from '@/api/getThemeData';
import * as Lang from '@/lang';

const TableDiv = styled.div`
    overflow-x:auto;
`;

const Table = styled.table`
    background-color:var(--secondary);
    width:100%;
    border-radius:20px;

    & > tr > th{
        ${tw`text-neutral-400`};
        text-align:left;
        font-weight:normal;
        padding:2.5em 1.5em .8em;
    }
    & > tr > td{
        padding:.5em 1.5em;
    }
    & > tr:last-of-type > td{
        padding:.5em 1.5em 2.5em;
    }
    & > tr > td > span{
        ${tw`text-neutral-400`};
        font-size:.7em;
    }
    & > tr > td:first-of-type{
        ${tw`text-neutral-400`};
    }
`;

const CardContainer = styled.div`
    ${tw`grid grid-cols-1 md:grid-cols-2 gap-2 sm:gap-4`};
`;

export default () => {
    const { search } = useLocation();
    const defaultPage = Number(new URLSearchParams(search).get('page') || '1');
    const [themeData, setThemeData] = useState();

    const [page, setPage] = useState(!isNaN(defaultPage) && defaultPage > 0 ? defaultPage : 1);
    const { clearFlashes, clearAndAddHttpError } = useFlash();
    const uuid = useStoreState((state) => state.user.data!.uuid);
    const rootAdmin = useStoreState((state) => state.user.data!.rootAdmin);
    const [showOnlyAdmin, setShowOnlyAdmin] = usePersistedState(`${uuid}:show_all_servers`, false);

    const { data: servers, error } = useSWR<PaginatedResult<Server>>(
        ['/api/client/servers', showOnlyAdmin && rootAdmin, page],
        () => getServers({ page, type: showOnlyAdmin && rootAdmin ? 'admin' : undefined })
    );

    useEffect(() => {
        if (!servers) return;
        if (servers.pagination.currentPage > 1 && !servers.items.length) {
            setPage(1);
        }
    }, [servers?.pagination.currentPage]);

    useEffect(() => {
        // Don't use react-router to handle changing this part of the URL, otherwise it
        // triggers a needless re-render. We just want to track this in the URL incase the
        // user refreshes the page.
        window.history.replaceState(null, document.title, `/${page <= 1 ? '' : `?page=${page}`}`);
    }, [page]);

    useEffect(() => {
        if (error) clearAndAddHttpError({ key: 'dashboard', error });
        if (!error) clearFlashes('dashboard');
    }, [error]);
    
    useEffect(() => {
        async function getThemeData() {
            const data = await getTheme();
            setThemeData(data.newserverlist);
        }
        getThemeData();
    }, []);

    return (
        <PageContentBlock title={'Dashboard'} showFlashKey={'dashboard'}>
            {rootAdmin && (
                <div css={tw`pr-4 mb-2 flex justify-end items-center`}>
                    <p css={tw`uppercase text-xs text-neutral-300 mr-2`}>
                        {showOnlyAdmin ? `${Lang.showing_others_servers}` : `${Lang.showing_your_servers}` }
                    </p>
                    <Switch
                        name={'show_all_servers'}
                        defaultChecked={showOnlyAdmin}
                        onChange={() => setShowOnlyAdmin((s) => !s)}
                    />
                </div>
            )}
            {themeData == 'cards' ? 
                <CardContainer>
                    {!servers ? (
                        <Spinner centered size={'large'} />
                            ) : (
                                <Pagination data={servers} onPageSelect={setPage}>
                                    {({ items }) =>
                                        items.length > 0 ? (
                                            items.map((server, index) => (
                                                <ServerCard key={server.uuid} server={server} css={index > 0 ? tw`mt-2` : undefined} />
                                            ))
                                        ) : (
                                            <p css={tw`text-center text-sm text-neutral-400`}>
                                                {showOnlyAdmin ?
                                                    `${Lang.there_are_no_other_servers_to_display}`
                                                    :
                                                    `${Lang.there_are_no_servers_associated_with_your_account}`
                                                }
                                            </p>
                                        )
                                    }
                                </Pagination>
                            )}
                </CardContainer>
                :
                <>
                    {themeData == 'table' ? 
                        <TableDiv>
                            <Table>
                                <tr>
                                    <th>ID</th>
                                    <th>{Lang.Name}</th>
                                    <th>{Lang.Allocation}</th>
                                    <th>CPU</th>
                                    <th>Ram</th>
                                    <th>Disk</th>
                                    <th>{Lang.Status}</th>
                                </tr>
                                {!servers ? (
                                    <Spinner centered size={'large'} />
                                ) : (
                                    <Pagination data={servers} onPageSelect={setPage}>
                                        {({ items }) =>
                                            items.length > 0 ? (
                                                items.map((server, index) => (
                                                    <ServerRow key={server.uuid} server={server} css={index > 0 ? tw`mt-2` : undefined} />
                                                ))
                                            ) : (
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <p css={tw`text-center text-sm text-neutral-400`}>
                                                            {showOnlyAdmin ?
                                                                `${Lang.there_are_no_other_servers_to_display}`
                                                                :
                                                                `${Lang.there_are_no_servers_associated_with_your_account}`
                                                            }
                                                        </p>
                                                    </td>
                                                </tr>
                                            )
                                        }
                                    </Pagination>
                                )}
                            </Table>
                        </TableDiv>
                        :
                        <Spinner centered size={'large'} />
                    }
                </>
            }
        </PageContentBlock>
    );
};
