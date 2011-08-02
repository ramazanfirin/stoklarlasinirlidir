package com.kalite.portal.ss.service.manager;

import java.util.List;

import org.springframework.transaction.annotation.Transactional;

import com.kalite.portal.ss.model.model.Product;
import com.kalite.portal.ss.service.dao.ProductDao;
@Transactional
public class ProductManager {
	private ProductDao productDao;

	public void save(Object object){
		productDao.save(object);
	}
	
	public void update(Object object){
		productDao.update(object);
	}
	
	public void saveorupdate(Object object){
		productDao.saveOrUpdate(object);
	}
	
	public void saveAll(List<Product> list){
		productDao.saveAll(list);
	}
	
	public void deleteAll(List<Product> list){
		productDao.deleteAll(list);
	}
	
	public List<Product> getProductList(){
		return productDao.getActiveProducts();
	}
	
	public Product findProduct(Long id){
		return productDao.findProduct(id);
	}
	
	
	
	
	
	
	
	public ProductDao getProductDao() {
		return productDao;
	}

	public void setProductDao(ProductDao productDao) {
		this.productDao = productDao;
	}
}
