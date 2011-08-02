package com.kalite.portal.ss.service.dao;

import java.util.Date;
import java.util.List;

import org.hibernate.Query;

import com.kalite.portal.ss.model.model.Campaign;

public class CampaignDao extends BaseDao{
	
	public List<Campaign> getActiveCampaigns(){
		List<Campaign> list=getHibernateTemplate().find("from Campaign");
		return list;
	}
	
	public Campaign findCampaign(Long id){
		List<Campaign> list=getHibernateTemplate().   find("from Campaign where id="+id);
		if(list.size()>0)
		    return list.get(0);     
		else
			return null;
	}
	
	public List<Campaign> getActiveCampaigns(Date date){
		String hql =  "select i from Campaign i where i.startDate<=:startDate and i.finishDate>:finishDate ";
		Query query = getSession().createQuery(hql);
		query.setParameter("startDate", date);
		query.setParameter("finishDate", date);
		List<Campaign> list=query.list();
		return list;         
	}
}
