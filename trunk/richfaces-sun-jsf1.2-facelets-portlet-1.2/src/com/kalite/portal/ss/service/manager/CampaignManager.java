package com.kalite.portal.ss.service.manager;

import java.util.Date;
import java.util.List;

import org.springframework.transaction.annotation.Transactional;

import com.kalite.portal.ss.model.model.Campaign;
import com.kalite.portal.ss.model.model.Product;
import com.kalite.portal.ss.service.dao.CampaignDao;
import com.kalite.portal.ss.service.dao.ProductDao;
@Transactional
public class CampaignManager {
	private CampaignDao dao;

	public void save(Object object){
		dao.save(object);
	}
	
	public void update(Object object){
		dao.update(object);
	}
	
	public void saveorupdate(Object object){
		dao.saveOrUpdate(object);
	}
	
	public void saveAll(List<Product> list){
		dao.saveAll(list);
	}
	
	public List<Campaign> getCampaignList(){
		return dao.getActiveCampaigns();
	}
	
	public Campaign findCampaign(Long id){
		return dao.findCampaign(id);
	}

	public List<Campaign> getActiveCampaigns(Date date){
		return dao.getActiveCampaigns(date);
	}
	
	public CampaignDao getDao() {
		return dao;
	}

	public void setDao(CampaignDao dao) {
		this.dao = dao;
	}
	
	
}
