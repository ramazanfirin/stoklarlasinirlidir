package com.kalite.portal.ss.model.model;

public class BaseModel {
	private Long id;
	private Boolean active;
	private String name;
	
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public Long getId() {
		return id;
	}
	public void setId(Long id) {
		this.id = id;
	}
	public Boolean getActive() {
		return active;
	}
	public void setActive(Boolean active) {
		this.active = active;
	}
	
	public static void copyAttributes(BaseModel source, BaseModel target){
		target.setActive(source.getActive());
		target.setId(source.getId());
		target.setName(source.getName());

	}
	public static void resetAttributes(BaseModel baseModel){
		baseModel.setActive(null);
		baseModel.setId(null);
		baseModel.setName(null);
	}
}
